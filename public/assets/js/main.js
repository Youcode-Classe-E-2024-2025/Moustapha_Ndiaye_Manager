['showRegister', 'showLogin'].forEach(buttonId => {
    document.getElementById(buttonId).addEventListener('click', function() {
        const isRegister = buttonId === 'showRegister';
        
        // Gérer les styles des boutons
        document.getElementById('showRegister').classList.toggle('bg-white', isRegister);
        document.getElementById('showRegister').classList.toggle('text-yellow-500', isRegister);
       
        document.getElementById('showLogin').classList.toggle('bg-white', !isRegister);
        document.getElementById('showLogin').classList.toggle('text-yellow-500', !isRegister);

        // Gérer la visibilité des formulaires
        document.getElementById('registerForm').classList.toggle('translate-x-full', !isRegister);
        document.getElementById('registerForm').classList.toggle('opacity-0', !isRegister);
        document.getElementById('registerForm').classList.toggle('hidden', !isRegister);
        document.getElementById('registerForm').classList.toggle('translate-x-0', isRegister);
        document.getElementById('registerForm').classList.toggle('opacity-100', isRegister);

        document.getElementById('loginForm').classList.toggle('translate-x-full', isRegister);
        document.getElementById('loginForm').classList.toggle('opacity-0', isRegister);
        document.getElementById('loginForm').classList.toggle('hidden', isRegister);
        document.getElementById('loginForm').classList.toggle('translate-x-0', !isRegister);
        document.getElementById('loginForm').classList.toggle('opacity-100', !isRegister);
    });
});