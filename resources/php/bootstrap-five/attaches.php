<div class="d-flex mb-3 gap-3 rounded">
    <div class="bg-light text-uppercase fs-5 fw-bold rounded p-4"><?php echo $file['extension']; ?></div>
    <div>
        <p class="fw-bold mb-0 text-lg">
            <a
                class="link-dark d-inline-flex justify-content-center align-items-center gap-1"
                href="<?php echo $file['url']; ?>"
                target="_blank"
            >
                <span><?php echo $title ?? $file['name']; ?></span>
                <svg
                    class="inline"
                    fill="currentColor"
                    height="12"
                    viewBox="0 0 16 16"
                    width="12"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"
                        fill-rule="evenodd"
                    />
                    <path
                        d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"
                        fill-rule="evenodd"
                    />
                </svg>
            </a>
        </p>
        <p class="fw-semibold text-secondary"><small><?php echo number_format($file['size'] * 0.000001, 2); ?>MiB</small></p>
    </div>
</div>
