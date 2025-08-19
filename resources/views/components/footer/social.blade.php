<ul class="flex gap-4">
    @foreach (config('watch.social_networks') as $name => $href)
    <li>
        <a href="{{ $href }}">
            <x-icon :$name class="size-9 fill-slate-800 hover:fill-violet-200"/>
        </a>  
    </li>
    @endforeach
</ul>