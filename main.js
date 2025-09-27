document.addEventListener('DOMContentLoaded', () => {
    const landingPage = document.querySelector('.landing_page');
    const button = document.querySelector('.button');
    const form = document.querySelector('form');
    const currentPage = parseInt(document.getElementById('pageContainer')?.getAttribute('data-page') || "1");
    const doneButton = document.querySelector('.done');
    const nextButton = document.querySelector('.next');
    const civilStatusSelect = document.getElementById('civilStatus');
    const otherStatusInput = document.getElementById('otherStatus');
    const steps = document.querySelectorAll(".progress-step");
    const titles = document.querySelectorAll(".progress-title");
    const progressLine = document.querySelector(".progress-container::before");
    const page = document.querySelectorAll(".form-page");
    let currentStep = currentPage - 1;

    // Initially display the landing page
    if (landingPage) {
      landingPage.style.display = 'block'; 
    }
  
    if (button) {
      button.addEventListener('click', () => {
        window.location.href = 'index.php?page=1';
      });
    }

    // Show the current page
    const currentPageElement = document.querySelector('.page' + currentPage);
    if (currentPageElement) currentPageElement.style.display = 'block';

    // Adjust button visibility
    if (currentPage === 4) {
        doneButton.style.display = 'block';
        nextButton.style.display = 'none';
    } else {
        doneButton.style.display = 'none';
        nextButton.style.display = 'block';
    }

    // Restore values
    form.querySelectorAll('input, select, textarea').forEach(input => {
        const storedValue = localStorage.getItem(input.name);
        if (storedValue) input.value = storedValue;

        input.addEventListener('input', () => {
            localStorage.setItem(input.name, input.value);
        });
    });

    // Back arrow functionality
    const backArrow = document.createElement('i');
    backArrow.className = 'bx bx-arrow-back back-arrow';
    document.querySelector('.main')?.appendChild(backArrow);

    if (currentPage === 1) backArrow.style.display = 'none';

    backArrow.addEventListener('click', () => {
        if (currentPage > 1) {
            localStorage.setItem('currentPage', currentPage - 1);
            window.location.href = `index.php?page=${currentPage - 1}`;
        }
    });

    // Next button functionality
    nextButton.addEventListener('click', () => {
        window.location.href = `index.php?page=${currentPage + 1}`;
    });

    // Done button functionality
    doneButton.addEventListener('click', () => {
        form.submit();
    });

    // Civil Status Handling
    function updateStatusDisplay() {
        if (civilStatusSelect.value === 'Others') {
            otherStatusInput.style.display = 'inline-block';
            civilStatusSelect.style.width = '200px';
        } else {
            otherStatusInput.style.display = 'none';
            civilStatusSelect.style.width = '';
        }
    }

    updateStatusDisplay();
    civilStatusSelect.addEventListener('change', updateStatusDisplay);

    //Update Progress Bar
    function updateStepProgress(hasErrors) {
        steps.forEach((step, index) => {
            if (index < currentStep) {
                step.classList.add("completed");
                step.textContent = "✔";
            } else if (index === currentStep) {
                step.classList.remove("completed");
                step.textContent = (index + 1).toString();
                if (hasErrors) {
                    step.classList.add("error");
                } else {
                    step.classList.remove("error");
                    step.classList.add("completed");
                    step.textContent = "✔";
                }
            } else {
                step.classList.remove("completed", "error");
                step.textContent = (index + 1).toString();
            }
        });

        // Update Active Progress Title
        titles.forEach((title, index) => {
            if (index === currentStep) {
                title.classList.add("active");
                if (hasErrors) title.style.color = "#a6c5c7"; 
            } else {
                title.classList.remove("active");
                title.style.color = "#a6c5c7";
            }
        });

        // Smoothly Adjust Progress Line Width
        const lineWidth = (currentStep / (steps.length - 1)) * 87;
        document.documentElement.style.setProperty('--progress-line-width', lineWidth + "%");
    }

    // Validate Inputs on Proceed
    document.querySelectorAll("#proceed").forEach(button => {
        button.addEventListener("click", () => {
            let inputs = page[currentStep].querySelectorAll("input, select");
            let allValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add("error");
                    allValid = false;
                } else {
                    input.classList.remove("error");
                }
            });

            updateStepProgress(!allValid);

            if (allValid && currentStep < page.length - 1) {
                page[currentStep].classList.remove("active");
                currentStep++;
                page[currentStep].classList.add("active");
                updateStepProgress(false);
            }
        });
    });

    updateStepProgress(false);

    


    
});