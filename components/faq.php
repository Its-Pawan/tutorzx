<style>
    .accordion-item {
        border: none;
        border-bottom: 1px solid #e0e0e0;
    }

    .accordion-button {
        padding: 20px 0;
        font-weight: 600;
        color: #333;
        background-color: transparent;
    }

    .accordion-button:not(.collapsed) {
        color: #333;
        background-color: transparent;
        box-shadow: none;
    }

    .accordion-button:focus {
        box-shadow: none;
        border-color: transparent;
    }

    .accordion-button::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23333'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }

    .accordion-body {
        padding: 0 0 20px 0;
    }
</style>

<?php
function faqs($question, $answer, $isFirst = false)
{
    $id = 'faq-' . strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $question));

    $showClass = $isFirst ? 'show' : '';
    $ariaExpanded = $isFirst ? 'true' : 'false';

    return '
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading-' . $id . '">
                <button class="accordion-button ' . ($isFirst ? '' : 'collapsed') . '" type="button" data-bs-toggle="collapse" data-bs-target="#' . $id . '" aria-expanded="' . $ariaExpanded . '" aria-controls="' . $id . '">
                    ' . $question . '
                </button>
            </h2>
            <div id="' . $id . '" class="accordion-collapse collapse ' . $showClass . '" aria-labelledby="heading-' . $id . '" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    ' . $answer . '
                </div>
            </div>
        </div>
    ';
}
?>