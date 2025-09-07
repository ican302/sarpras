<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-[#3A3A3A] hover:bg-black text-white shadow-lg font-bold py-2 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 transition ease-in-out duration-150 flex items-center']) }}>
    {{ $slot }}
</button>
