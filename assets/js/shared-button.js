jQuery(document).ready(function ($) {
    const shareModal = $("#hy-share-modal");
    const copyLinkButton = $("#hy-copy-link-button");
    const copyLinkText = $("#hy-copy-link-text");

    // --- OPEN MODAL ---
    // Use a delegated event listener for '.hy-share-button'
    $(document).on("click", ".hy-share-button", function (e) {
        e.preventDefault();

        const button = $(this);
        const title = button.data("title");
        const url = button.data("url");
        const text = button.data("text");

        // Store data in the modal itself for easy access by share links
        shareModal.data("url", url);
        shareModal.data("title", title);
        shareModal.data("text", text);

        // Reset copy button text
        copyLinkText.text("Copy Link");
        copyLinkButton.prop("disabled", false);
        copyLinkButton.removeClass("bg-green-500 text-white").addClass("bg-gray-200 text-gray-900");

        // Show the modal
        shareModal.removeClass("hidden");

        // Focus trap for accessibility
        shareModal.find("button, a").first().focus();
    });

    // --- CLOSE MODAL ---
    function closeModal() {
        shareModal.addClass("hidden");
        // Return focus to the button that opened the modal
        $(".hy-share-button").last().focus();
    }

    // Close by clicking the close button or the overlay
    $("#hy-share-modal-close, #hy-share-modal-overlay").on("click", function () {
        closeModal();
    });

    // Close by pressing the Escape key
    $(document).on("keydown", function (e) {
        if (e.key === "Escape" && !shareModal.hasClass("hidden")) {
            closeModal();
        }
    });

    // --- HANDLE SHARE CLICKS ---
    $(document).on("click", ".hy-share-link", function (e) {
        e.preventDefault();

        const platform = $(this).data("platform");
        const url = shareModal.data("url");
        const title = shareModal.data("title");
        const text = shareModal.data("text");
        let shareUrl = "";

        // Encode components for URL safety
        const encodedUrl = encodeURIComponent(url);
        const encodedTitle = encodeURIComponent(title);
        const encodedText = encodeURIComponent(text);

        // Construct share URLs for different platforms
        switch (platform) {
            case "facebook":
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`;
                break;

            case "twitter":
                // Updated for X (formerly Twitter) - using x.com
                shareUrl = `https://twitter.com/intent/tweet?url=${encodedUrl}&text=${encodedText}`;
                break;

            case "linkedin":
                shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodedUrl}`;
                break;

            case "whatsapp":
                // WhatsApp sharing
                shareUrl = `https://wa.me/?text=${encodeURIComponent(text + " " + url)}`;
                break;

            case "telegram":
                // Telegram sharing
                shareUrl = `https://t.me/share/url?url=${encodedUrl}&text=${encodedText}`;
                break;

            case "email":
                // Email sharing
                const emailSubject = encodedTitle;
                const emailBody = encodeURIComponent(`${text}\n\n${url}`);
                shareUrl = `mailto:?subject=${emailSubject}&body=${emailBody}`;

                // For email, we don't open a popup, we just change window location
                window.location.href = shareUrl;
                closeModal(); // Close modal after initiating email
                return;
        }

        // Open social sharing popup
        if (shareUrl) {
            const popup = window.open(
                shareUrl,
                "social-share-window",
                "width=600,height=500,scrollbars=yes,resizable=yes,menubar=no,toolbar=no,status=no"
            );

            // Check if popup was blocked
            if (!popup || popup.closed || typeof popup.closed === "undefined") {
                // Fallback: open in new tab
                window.open(shareUrl, "_blank");
            }

            // Optional: Close modal after sharing (you can remove this if you want to keep it open)
            setTimeout(() => {
                closeModal();
            }, 1000);
        }
    });

    // --- HANDLE COPY LINK ---
    copyLinkButton.on("click", function (e) {
        e.preventDefault();

        const url = shareModal.data("url");

        // Check if the Clipboard API is available
        if (navigator.clipboard && window.isSecureContext) {
            // Use the modern Navigator Clipboard API
            navigator.clipboard
                .writeText(url)
                .then(() => {
                    showCopySuccess();
                })
                .catch((err) => {
                    console.error("Failed to copy using Clipboard API: ", err);
                    fallbackCopyTextToClipboard(url);
                });
        } else {
            // Fallback for older browsers or non-secure contexts
            fallbackCopyTextToClipboard(url);
        }
    });

    // Success feedback for copy action
    function showCopySuccess() {
        copyLinkText.text("Copied!");
        copyLinkButton.prop("disabled", true);
        copyLinkButton
            .removeClass("bg-gray-200 hover:bg-gray-300 text-gray-900")
            .addClass("bg-green-500 text-white");

        // Reset after 3 seconds
        setTimeout(() => {
            copyLinkText.text("Copy Link");
            copyLinkButton.prop("disabled", false);
            copyLinkButton
                .removeClass("bg-green-500 text-white")
                .addClass("bg-gray-200 text-gray-900 hover:bg-gray-300");
        }, 3000);
    }

    // Fallback copy method for older browsers
    function fallbackCopyTextToClipboard(text) {
        const textArea = document.createElement("textarea");
        textArea.value = text;

        // Avoid scrolling to bottom
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";
        textArea.style.opacity = "0";

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            const successful = document.execCommand("copy");
            if (successful) {
                showCopySuccess();
            } else {
                showCopyError();
            }
        } catch (err) {
            console.error("Fallback: Oops, unable to copy", err);
            showCopyError();
        }

        document.body.removeChild(textArea);
    }

    // Error feedback for copy action
    function showCopyError() {
        copyLinkText.text("Copy Failed!");
        copyLinkButton
            .removeClass("bg-gray-200 hover:bg-gray-300 text-gray-900")
            .addClass("bg-red-500 text-white");

        // Reset after 3 seconds
        setTimeout(() => {
            copyLinkText.text("Copy Link");
            copyLinkButton.prop("disabled", false);
            copyLinkButton
                .removeClass("bg-red-500 text-white")
                .addClass("bg-gray-200 text-gray-900 hover:bg-gray-300");
        }, 3000);
    }

    // --- ACCESSIBILITY IMPROVEMENTS ---
    // Handle keyboard navigation within modal
    shareModal.on("keydown", function (e) {
        if (e.key === "Tab") {
            const focusableElements = shareModal.find(
                'button, a, input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );
            const firstElement = focusableElements.first();
            const lastElement = focusableElements.last();

            if (e.shiftKey) {
                // Shift + Tab (backward)
                if (document.activeElement === firstElement[0]) {
                    e.preventDefault();
                    lastElement.focus();
                }
            } else {
                // Tab (forward)
                if (document.activeElement === lastElement[0]) {
                    e.preventDefault();
                    firstElement.focus();
                }
            }
        }
    });
});
