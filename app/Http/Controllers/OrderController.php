<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Enums\UserRole;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role === UserRole::Admin) {
            // Адміністратор бачить всі замовлення
            $orders = Order::latest()
                ->when($request->search, function ($query, $search) {
                    $query->where('service_type', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%");
                })
                ->paginate(6)
                ->withQueryString();
        } else {
            // Звичайний користувач бачить тільки свої замовлення
            $orders = Order::where('user_id', auth()->id())
                ->latest()
                ->when($request->search, function ($query, $search) {
                    $query->where('service_type', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%");
                })
                ->paginate(6)
                ->withQueryString();
        }

        return view('pages.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Дозволяємо адміну переглядати всі замовлення
        if (
            auth()->user()->role !== UserRole::Admin &&
            $order->user_id !== auth()->id()
        ) {
            abort(403, 'У вас немає доступу до цього замовлення.');
        }

        return view('pages.orders.show', compact('order'));
    }

    public function showCreateForm()
    {
        return view('pages.orders.create');
    }

    public function store(Request $request)
    {
        // Валідація без поля status
        $validated = $request->validate([
            'service_type' => 'required|string',
            'description' => 'required|string',
            'images' => 'required|array|min:2',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:20480',
        ]);
        
        // Створення замовлення з встановленням статусу за замовчуванням
        $order = new Order([
            'service_type' => $validated['service_type'],
            'description' => $validated['description'],
            'status' => 'new', //статус  автоматично
            'user_id' => auth()->id(),
        ]);
        
        $order->save();
        
        // Обробка зображень...
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('image-order', 'public'); //шлях для збереження
            }
        }
        $order->images = json_encode($imagePaths);
        $order->save();
        
        return redirect()->route('orders.index')
            ->with('success', 'Замовлення успішно створено!');
    }

    public function cancel(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Перевірка чи не виконано вже замовлення
        if ($order->status === 'completed') {
            return redirect()->back()->with('error', 'Неможливо скасувати виконане замовлення!');
        }

        // Перевірка прав: тільки власник або адміністратор може скасувати замовлення
        if ($order->user_id !== auth()->id() && auth()->user()->role !== UserRole::Admin) {
            abort(403, 'У вас немає доступу до скасування цього замовлення.');
        }

        // Змінюємо статус і зберігаємо
        $order->status = 'canceled';
        $order->save();

        return redirect()->back()->with('success', 'Замовлення успішно скасовано!');
    }

    public function edit(Order $order)
    {
        // Перевірка прав доступу
        if ($order->user_id !== auth()->id() && auth()->user()->role !== UserRole::Admin) {
            abort(403, 'У вас немає доступу до редагування цього замовлення.');
        }

        return view('pages.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        // Перевірка прав доступу
        if ($order->user_id !== auth()->id() && auth()->user()->role !== UserRole::Admin) {
            abort(403, 'У вас немає доступу до оновлення цього замовлення.');
        }

        // Валідація даних
        $validated = $request->validate([
            'service_type' => 'required|string',
            'description' => 'required|string|max:150',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'status' => 'nullable|in:new,processing,completed,canceled', // Статус тільки для адміністратора
        ]);

        // Оновлення дозволених полів
        $order->service_type = $validated['service_type'];
        $order->description = $validated['description'];

        // Оновлення статусу (тільки для адміністратора)
        if (auth()->user()->role === UserRole::Admin && isset($validated['status'])) {
            $order->status = $validated['status'];
        }

        // Оновлення зображень
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('image-order', 'public');
            }
            $order->images = json_encode($imagePaths);
        }

        $order->save();

        return redirect()->route('orders.show', $order->id)->with('success', 'Замовлення успішно оновлено!');
    }

    protected function validateOrder(Request $request)
    {
        return $request->validate([
            'status' => 'required|in:new,processing,completed,canceled',
            'service_type' => 'required|string',
            'description' => 'required|string|max:150',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
        ]);
    }
    
    public function setPrice(Request $request, Order $order)
    {
        // Перевірка прав доступу
        if ($order->user_id !== auth()->id() && auth()->user()->role !== UserRole::Admin) {
            abort(403, 'У вас немає доступу до оновлення ціни цього замовлення.');
        }

        // Валідація даних
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        // Оновлення ціни
        $order->price = $validated['price'];
        $order->save();

        return redirect()->route('orders.show', $order->id)->with('success', 'Ціна замовлення успішно оновлена!');
    }

    public function updatePaymentType(Request $request, Order $order)
    {
        if ($order->payment_status === \App\Enums\PaymentStatus::Paid) {
            return back()->with('error', 'Неможливо змінити тип оплати для вже оплаченого замовлення.');
        }

        $validated = $request->validate([
            'payment_status' => 'required|string|in:pending,cash,failed,paid',
        ]);

        $order->payment_status = $validated['payment_status'];
        $order->save();

        return back()->with('success', 'Тип оплати успішно оновлено.');
    }
}
