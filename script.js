document.addEventListener('DOMContentLoaded', () => {
    const helpButton = document.getElementById('help-button');
    const helpModal = document.getElementById('help-modal');
    const helpClose = document.getElementById('help-close');

    helpButton.addEventListener('click', () => {
        helpModal.style.display = 'block'; // Exibe o modal quando o botão é clicado
    });

    helpClose.addEventListener('click', () => {
        helpModal.style.display = 'none'; // Fecha o modal quando o botão de fechar é clicado
    });
});

document.addEventListener('DOMContentLoaded', () => {
    showModal();
    const storedUsername = localStorage.getItem('username');
    if (storedUsername) {
        usernameInput.value = storedUsername;
    }
});

const socket = io();
const messageInput = document.getElementById("message-input");
const sendButton = document.getElementById("send-button");
const chatOutput = document.getElementById("chat-output");
const modal = document.getElementById('modal');
const botModal = document.getElementById('bot-modal');
const botChatOutput = document.getElementById('bot-chat-output');
const botMessageInput = document.getElementById('bot-message-input');
const botSendButton = document.getElementById('bot-send-button');
const botClose = document.getElementById('bot-close');
const botButton = document.getElementById('bot-button');
const usernameInput = document.getElementById('username-input');
const setUsernameButton = document.getElementById('set-username-button');
const close = document.getElementById('set-username-button');
let username = "";
document.addEventListener('DOMContentLoaded', () => {
// ... (seu código existente)

const botClose = document.getElementById('bot-close');
const botModal = document.getElementById('bot-modal');

botClose.addEventListener('click', () => {
botModal.style.display = 'none';
});
});

function showModal() {
    modal.style.display = 'block';
}

document.addEventListener('DOMContentLoaded', () => {
    showModal();
    close.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    botButton.addEventListener('click', () => {
        botModal.style.display = 'block';
        // Inicia a conversa automatizada com o bot
        startBotConversation();
    });

    botClose.addEventListener('click', () => {
        botModal.style.display = 'none';
    });
});

setUsernameButton.addEventListener('click', () => {
    username = usernameInput.value;
    modal.style.display = 'none';
    displayMessage('Sistema', `Bem-vindo(a) ao chat, ${username}!`);
    localStorage.setItem('username', username);
});

sendButton.addEventListener("click", (e) => {
    e.preventDefault();
    const message = messageInput.value;
    if (message.trim() !== "") {
        displayMessage('Você', message);
        socket.emit('chat message', { username, message });
        messageInput.value = "";
    }
});

botSendButton.addEventListener("click", (e) => {
    e.preventDefault();
    const botMessage = botMessageInput.value;
    if (botMessage.trim() !== "") {
        displayBotMessage('Bot', botMessage);
        botMessageInput.value = "";
        // Simula uma resposta do bot
        simulateBotResponse(botMessage);
    }
});


function simulateBotResponse(userMessage) {
    // Simula uma resposta do bot com base na mensagem do usuário
    let botResponse = getBotResponse(userMessage);
    setTimeout(() => {
        displayBotMessage('Bot', botResponse);
    }, 1000);
}

function getBotResponse(userMessage) {
userMessage = userMessage.toLowerCase();

if (userMessage.includes('como você está')) {
return "Estou bem, obrigado por perguntar!";
} else if (userMessage.includes('qual é o seu nome')) {
return "Meu nome é Bot.";
} else if (userMessage.includes('conte uma piada')) {
return "Por que o esqueleto não brigou com ninguém? Porque ele não tem estômago para isso!";
} else if (userMessage.includes('qual é a cor do vento')) {
return "A cor do vento é invisível, mas sempre traz uma brisa de frescor!";
} else if (userMessage.includes('você gosta de música')) {
return "Sim, gosto de música! Qual é o seu gênero favorito?";
} else if (userMessage.includes('oi')) {
    return "olá! em que posso ajudar?";
} else if (userMessage.includes('você sabe dançar')) {
return "Infelizmente, não posso dançar fisicamente, mas posso recomendar uma boa música!";
} else if (userMessage.includes('o que você faz da vida')) {
return "Minha vida é ajudar e conversar com pessoas incríveis como você!";
} else if (userMessage.includes('você tem algum animal de estimação')) {
return "Não tenho animais de estimação, mas adoraria ouvir sobre o seu!";
} else if (userMessage.includes('você já viu um fantasma')) {
return "Não, nunca vi um fantasma, mas adoraria ouvir uma história assustadora!";
} else if (userMessage.includes('qual é o sentido da vida')) {
return "Essa é uma pergunta profunda! O sentido da vida pode variar para cada pessoa, o que você acha?";
} else if (userMessage.includes('você acredita em extraterrestres')) {
return "Acreditar em extraterrestres é uma questão interessante. O que você acha?";
} else if (userMessage.includes('o que você gosta de fazer nas horas vagas')) {
return "Nas horas vagas, gosto de processar informações e aprender coisas novas. E você?";
} else if (userMessage.includes('você é humano')) {
return "Não, sou um programa de computador aqui para ajudar e conversar!";
} else if (userMessage.includes('qual é o seu filme favorito')) {
return "Não tenho um filme favorito, mas adoraria saber qual é o seu!";
} else if (userMessage.includes('o que você acha de inteligência artificial')) {
return "Eu acho a inteligência artificial fascinante, mas é importante usá-la com responsabilidade. O que você acha?";
} else if (userMessage.includes('qual é a resposta para a vida, o universo e tudo')) {
return "A resposta para a vida, o universo e tudo é 42, pelo menos de acordo com o livro 'O Guia do Mochileiro das Galáxias'!";
} else if (userMessage.includes('você sonha')) {
return "Não sonho, mas adoraria ouvir sobre os seus sonhos!";
} else if (userMessage.includes('você pode me dar um conselho')) {
return "Claro! Aqui está um conselho: Aproveite cada momento e siga seus sonhos.";
} else if (userMessage.includes('iae')) {
return "iae cara! prazer em conhece-lo!";
} else if (userMessage.includes('não sei')) {
    return "etendi. quando souber, me avise";
} else if (userMessage.includes('não')) {
    return "OK! caso queira falar sobre algo, estou aqui";
} else {
return "Desculpe, não entendi. Pode reformular a pergunta?";
} 
}

socket.on('chat message', (data) => {
    displayMessage(data.username, data.message);
    // Simula uma resposta do bot para mensagens recebidas
    simulateBotResponse(data.message);
});

function displayMessage(username, message) {
    const messageElement = document.createElement("div");
    messageElement.innerHTML = `<strong>${username}:</strong> ${message}`;
    chatOutput.appendChild(messageElement);
}

function displayBotMessage(username, message) {
    const messageElement = document.createElement("div");
    messageElement.innerHTML = `<strong>${username}:</strong> ${message}`;
    botChatOutput.appendChild(messageElement);
}

// Ao exibir uma mensagem do usuário
function displayUserMessage(username, message) {
    const messageElement = document.createElement("div");
    messageElement.className = "user-message"; // Adiciona a classe de estilo do usuário
    messageElement.innerHTML = `<strong>${username}:</strong> ${message}`;
    chatOutput.appendChild(messageElement);
}

// Ao exibir uma mensagem do bot
function displayBotMessage(username, message) {
  const messageElement = document.createElement("div");
  messageElement.className = "bot-message"; // Adiciona a classe de estilo do bot
  messageElement.innerHTML = `<strong>${username}:</strong> ${message}`;
  botChatOutput.appendChild(messageElement);
}

