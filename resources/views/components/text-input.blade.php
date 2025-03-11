@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'px-2 py-2.5 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[10px] rounded-bl-[10px] rounded-[4px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000']) }}>
