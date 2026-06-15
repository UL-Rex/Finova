
        const signUpBtn = document.getElementById('signUpBtn');
        const signInBtn = document.getElementById('signInBtn');
        const container = document.getElementById('container');

        // Event listener to slide to Sign Up
        signUpBtn.addEventListener('click', () => {
            container.classList.add('right-panel-active');
        });

        // Event listener to slide to Sign In
        signInBtn.addEventListener('click', () => {
            container.classList.remove('right-panel-active');
        });

        // Optional: Prevent default form submission to maintain mockup state
        document.getElementById('signInForm').addEventListener('submit', (e) => e.preventDefault());
        document.getElementById('signUpForm').addEventListener('submit', (e) => e.preventDefault());
   