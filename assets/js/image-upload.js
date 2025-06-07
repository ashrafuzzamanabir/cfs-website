// Image compression and upload handling
class ImageUploadHandler {
    constructor() {
        this.loadingBar = null;
        this.createLoadingBar();
        this.setupEventListeners();
    }

    createLoadingBar() {
        // Create loading bar container
        this.loadingBar = document.createElement('div');
        this.loadingBar.className = 'image-upload-loading';
        this.loadingBar.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: #f0f0f0;
            z-index: 9999;
            display: none;
        `;

        // Create progress bar
        const progress = document.createElement('div');
        progress.className = 'image-upload-progress';
        progress.style.cssText = `
            width: 0%;
            height: 100%;
            background: #007bff;
            transition: width 0.3s ease;
        `;

        this.loadingBar.appendChild(progress);
        document.body.appendChild(this.loadingBar);
    }

    setupEventListeners() {
        // Find all file inputs that accept images
        const fileInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
        fileInputs.forEach(input => {
            input.addEventListener('change', (e) => this.handleImageUpload(e));
        });
    }

    async handleImageUpload(event) {
        const file = event.target.files[0];
        if (!file) return;

        // Show loading bar
        this.showLoadingBar();

        try {
            // Compress image
            const compressedFile = await this.compressImage(file);
            
            // Update the file input with compressed file
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(compressedFile);
            event.target.files = dataTransfer.files;

            // Complete loading bar
            this.updateLoadingBar(100);
            setTimeout(() => this.hideLoadingBar(), 500);

        } catch (error) {
            console.error('Error compressing image:', error);
            this.hideLoadingBar();
        }
    }

    async compressImage(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = (event) => {
                const img = new Image();
                img.src = event.target.result;
                img.onload = () => {
                    // Create canvas
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');

                    // Calculate new dimensions while maintaining aspect ratio
                    let width = img.width;
                    let height = img.height;
                    const maxSize = 1200; // Max dimension

                    if (width > height && width > maxSize) {
                        height = Math.round((height * maxSize) / width);
                        width = maxSize;
                    } else if (height > maxSize) {
                        width = Math.round((width * maxSize) / height);
                        height = maxSize;
                    }

                    canvas.width = width;
                    canvas.height = height;

                    // Draw image on canvas
                    ctx.drawImage(img, 0, 0, width, height);

                    // Convert to blob with quality 0.7
                    canvas.toBlob((blob) => {
                        // Create new file from blob
                        const compressedFile = new File([blob], file.name, {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        });

                        // Check if file size is under 300KB
                        if (compressedFile.size <= 307200) { // 300KB in bytes
                            resolve(compressedFile);
                        } else {
                            // If still too large, try with lower quality
                            canvas.toBlob((finalBlob) => {
                                const finalFile = new File([finalBlob], file.name, {
                                    type: 'image/jpeg',
                                    lastModified: Date.now()
                                });
                                resolve(finalFile);
                            }, 'image/jpeg', 0.5);
                        }
                    }, 'image/jpeg', 0.7);
                };
                img.onerror = reject;
            };
            reader.onerror = reject;
        });
    }

    showLoadingBar() {
        this.loadingBar.style.display = 'block';
        this.updateLoadingBar(0);
    }

    hideLoadingBar() {
        this.loadingBar.style.display = 'none';
        this.updateLoadingBar(0);
    }

    updateLoadingBar(progress) {
        const progressBar = this.loadingBar.querySelector('.image-upload-progress');
        progressBar.style.width = `${progress}%`;
    }
}

// Initialize the image upload handler when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new ImageUploadHandler();
}); 