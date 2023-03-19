<aside class="bg-light rounded p-5 d-flex gap-4 mb-3">
    <div
        class="d-flex justify-content-center align-items-start align-items-sm-center"
        style="color: #e2e8f0;"
    >
        <svg
            fill="currentColor"
            height="6rem"
            viewBox="0 0 16 16"
            width="6rem"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M7.005 3.1a1 1 0 1 1 1.99 0l-.388 6.35a.61.61 0 0 1-1.214 0L7.005 3.1ZM7 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z"
            />
        </svg>
    </div>

    <div class="flex-grow-1">
        <p class="fs-4 fw-semibold mb-0"><?= $data('title'); ?></p>
        <p><?= $data('message'); ?></p>
    </div>
</aside>
