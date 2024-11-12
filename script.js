document.addEventListener('DOMContentLoaded', function () {
    const openSignupLink = document.getElementById('openSignupLink');
    const openLoginLink = document.getElementById('openLoginLink');
    const popup = document.getElementById('popup');
    const signupForm = document.getElementById('signupForm');
    const loginForm = document.getElementById('loginForm');
    const switchToLogin = document.querySelector('.switchToLogin');
    const switchToSignup = document.querySelector('.switchToSignup');
    const signupFormElement = document.getElementById('signupFormElement');
    const loginFormElement = document.getElementById('loginFormElement');
    const userFullName = document.getElementById('userFullName');

    let users = [];

    // Abrir pop-up com o formulário de Cadastro
    openSignupLink.addEventListener('click', (e) => {
        e.preventDefault();
        popup.style.display = 'block';
        signupForm.style.display = 'flex';
        loginForm.style.display = 'none';
    });

    // Abrir pop-up com o formulário de Login
    openLoginLink.addEventListener('click', (e) => {
        e.preventDefault();
        popup.style.display = 'block';
        loginForm.style.display = 'flex';
        signupForm.style.display = 'none';
    });

    // Alternar para o formulário de login dentro do pop-up
    switchToLogin.addEventListener('click', (e) => {
        e.preventDefault();
        signupForm.style.display = 'none';
        loginForm.style.display = 'flex';
    });

    // Alternar para o formulário de cadastro dentro do pop-up
    switchToSignup.addEventListener('click', (e) => {
        e.preventDefault();
        loginForm.style.display = 'none';
        signupForm.style.display = 'flex';
    });

    // Fechar o pop-up ao clicar fora dele
    window.addEventListener('click', (e) => {
        if (e.target === popup) {
            popup.style.display = 'none';
        }
    });

    // Cadastro de usuário
signupFormElement.addEventListener('submit', (e) => {
    e.preventDefault();
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Enviar os dados para o backend em PHP
    const data = new FormData();
    data.append('username', username);
    data.append('email', email);
    data.append('password', password);

    fetch('signup.php', {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Cadastro realizado com sucesso! Agora faça login.');
            signupForm.style.display = 'none';
            loginForm.style.display = 'flex';
        } else {
            alert('Erro no cadastro: ' + data.message);
        }
    })
    .catch(error => console.error('Erro:', error));
});

// Login de usuário
loginFormElement.addEventListener('submit', (e) => {
    e.preventDefault();
    const loginEmail = document.getElementById('loginEmail').value;
    const loginPassword = document.getElementById('loginPassword').value;

    // Enviar os dados para o backend em PHP
    const data = new FormData();
    data.append('email', loginEmail);
    data.append('password', loginPassword);

    fetch('login.php', {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Login realizado com sucesso!');
            userFullName.textContent = data.username; // O nome do usuário será retornado
            userFullName.style.display = 'inline';
            openSignupLink.style.display = 'none';
            openLoginLink.style.display = 'none';
            popup.style.display = 'none';
        } else {
            alert('Erro no login: ' + data.message);
        }
    })
    .catch(error => console.error('Erro:', error));
})});
