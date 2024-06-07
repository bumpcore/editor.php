<aside class="bg-gray-100 rounded-xl p-8 flex gap-4 mb-4">
    <div class="text-slate-400 flex justify-center items-start sm:items-center">
        <svg
            class="bi bi-exclamation-lg w-12 h-12"
            fill="currentColor"
            viewBox="0 0 16 16"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M7.005 3.1a1 1 0 1 1 1.99 0l-.388 6.35a.61.61 0 0 1-1.214 0L7.005 3.1ZM7 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z"
            />
        </svg>
    </div>

    <div class="grow">
        <p class="text-lg font-semibold"><?php echo $data('title'); ?></p>
        <p><?php echo $data('message'); ?></p>
    </div>
</aside>
