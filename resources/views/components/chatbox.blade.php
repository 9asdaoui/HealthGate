<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatBox</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        chatIndigo: '#4361ee',
                        chatLavender: '#7371fc',
                        chatMidnight: '#1f2d56',
                        chatSky: '#e2f0ff',
                        chatClouds: '#f8fafc',
                        chatBubbleUser: '#e3f4ff',
                        chatBubbleBot: '#f0f0ff',
                        chatAccent: '#5e60ce',
                        chatMint: '#72efdd',
                        chatShadow: '#d8e2ef'
                    },
                    keyframes: {
                        typing: {
                            '0%': {
                                transform: 'translateY(0)'
                            },
                            '33%': {
                                transform: 'translateY(-5px)'
                            },
                            '66%': {
                                transform: 'translateY(2px)'
                            },
                            '100%': {
                                transform: 'translateY(0)'
                            }
                        },
                        fadeIn: {
                            from: {
                                opacity: '0',
                                transform: 'translateY(15px) scale(0.95)'
                            },
                            to: {
                                opacity: '1',
                                transform: 'translateY(0) scale(1)'
                            }
                        },
                        pulse: {
                            '0%': {
                                opacity: '1',
                                transform: 'scale(1)'
                            },
                            '50%': {
                                opacity: '0.6',
                                transform: 'scale(1.1)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'scale(1)'
                            }
                        },
                        float: {
                            '0%': {
                                transform: 'translateY(0) rotate(0deg)'
                            },
                            '25%': {
                                transform: 'translateY(-8px) rotate(2deg)'
                            },
                            '50%': {
                                transform: 'translateY(0) rotate(0deg)'
                            },
                            '75%': {
                                transform: 'translateY(5px) rotate(-2deg)'
                            },
                            '100%': {
                                transform: 'translateY(0) rotate(0deg)'
                            }
                        },
                        rotate: {
                            '0%': {
                                transform: 'rotate(0deg) scale(1)'
                            },
                            '50%': {
                                transform: 'rotate(180deg) scale(1.15)'
                            },
                            '100%': {
                                transform: 'rotate(360deg) scale(1)'
                            }
                        },
                        bounce: {
                            '0%, 100%': {
                                transform: 'translateY(0) scale(1)',
                                boxShadow: '0 5px 15px rgba(0,0,0,0.1)'
                            },
                            '50%': {
                                transform: 'translateY(-20px) scale(1.05)',
                                boxShadow: '0 15px 25px rgba(0,0,0,0.05)'
                            }
                        },
                        shimmer: {
                            '0%': {
                                backgroundPosition: '-400px 0'
                            },
                            '100%': {
                                backgroundPosition: '400px 0'
                            }
                        },
                        slideIn: {
                            '0%': {
                                transform: 'translateX(100%)'
                            },
                            '100%': {
                                transform: 'translateX(0)'
                            }
                        },
                        slideOut: {
                            '0%': {
                                transform: 'translateX(0)'
                            },
                            '100%': {
                                transform: 'translateX(100%)'
                            }
                        }
                    },
                    animation: {
                        typing: 'typing 1.5s ease-in-out infinite',
                        fadeIn: 'fadeIn 0.5s cubic-bezier(0.22, 1, 0.36, 1)',
                        pulse: 'pulse 2.5s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        float: 'float 6s ease-in-out infinite',
                        rotate: 'rotate 1.2s cubic-bezier(0.68, -0.55, 0.27, 1.55)',
                        bounce: 'bounce 5s infinite cubic-bezier(0.4, 0, 0.2, 1)',
                        shimmer: 'shimmer 3s infinite linear',
                        slideIn: 'slideIn 0.5s ease-out',
                        slideOut: 'slideOut 0.5s ease-in'
                    },
                    boxShadow: {
                        'chatGlow': '0 0 20px rgba(115, 113, 252, 0.6)',
                        'chatMessage': '0 3px 12px rgba(31, 45, 86, 0.08)',
                        'chatFloating': '0 10px 25px rgba(0, 0, 0, 0.12)',
                        'chatInset': 'inset 0 2px 5px rgba(0, 0, 0, 0.05)'
                    }
                }
            }
        }
    </script>
    <style>
        .message-shine {
            position: relative;
            overflow: hidden;
        }

        .message-shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.5), transparent);
            transform: rotate(30deg);
            animation: shine 4s infinite cubic-bezier(0.6, 0, 0.4, 1);
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) rotate(30deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            60% {
                opacity: 0.5;
            }

            100% {
                transform: translateX(100%) rotate(30deg);
                opacity: 0;
            }
        }

        .pop-animation {
            animation: pop 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes pop {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .ripple-effect {
            position: relative;
            overflow: hidden;
        }

        .ripple-effect::after {
            content: "";
            display: block;
            position: absolute;
            border-radius: 50%;
            width: 100px;
            height: 100px;
            background-color: rgba(255, 255, 255, 0.4);
            transform: scale(0);
            animation: ripple 0.8s linear;
        }

        @keyframes ripple {
            0% {
                transform: scale(0);
                opacity: 1;
            }

            100% {
                transform: scale(8);
                opacity: 0;
            }
        }

        .user-message {
            transform-origin: bottom right;
        }

        .bot-message {
            transform-origin: bottom left;
        }

        #chat-body {
            scroll-behavior: smooth;
        }

        .chat-bubble {
            position: relative;
        }

        .chat-bubble::after {
            content: '';
            position: absolute;
            bottom: -6px;
            width: 12px;
            height: 12px;
            background: inherit;
            border-radius: 2px;
        }

        .user-message::after {
            right: 10px;
            transform: rotate(45deg);
        }

        .bot-message::after {
            left: 10px;
            transform: rotate(45deg);
        }

        .shimmer-bg {
            background: linear-gradient(to right, #f0f0ff 10%, #e9eefa 20%, #f0f0ff 30%);
            background-size: 800px 100%;
            animation: shimmer 3s infinite linear;
        }

        .glowing-effect {
            box-shadow: 0 0 15px rgba(115, 113, 252, 0.4);
            transition: box-shadow 0.3s ease;
        }

        .glowing-effect:hover {
            box-shadow: 0 0 25px rgba(115, 113, 252, 0.6);
        }

        .floating-bot {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .chat-header {
            background-image: linear-gradient(135deg, #4361ee 0%, #7371fc 50%, #5e60ce 100%);
        }

        .chat-input:focus {
            box-shadow: 0 0 0 3px rgba(115, 113, 252, 0.3);
        }
    </style>
</head>

<body class="bg-gray-100 h-screen flex justify-center items-center font-sans">
    <div id="chat-bot-icon"
        class="fixed bottom-5 right-5 w-16 h-16 rounded-full bg-chatIndigo flex justify-center items-center cursor-pointer shadow-chatGlow z-50 transition-all duration-700 hover:scale-110 active:scale-90 animate-bounce glowing-effect">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-9 h-9 fill-white floating-bot">
            <path
                d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 0 1 7 7h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h1a7 7 0 0 1 7-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 0 1 2-2M7.5 13A2.5 2.5 0 0 0 5 15.5A2.5 2.5 0 0 0 7.5 18a2.5 2.5 0 0 0 2.5-2.5A2.5 2.5 0 0 0 7.5 13m9 0a2.5 2.5 0 0 0-2.5 2.5a2.5 2.5 0 0 0 2.5 2.5a2.5 2.5 0 0 0 2.5-2.5a2.5 2.5 0 0 0-2.5-2.5M9 3c-.55 0-1 .45-1 1s.45 1 1 1s1-.45 1-1s-.45-1-1-1m6 0c-.55 0-1 .45-1 1s.45 1 1 1s1-.45 1-1s-.45-1-1-1z" />
        </svg>
        <div class="absolute -top-1 -right-1 w-3 h-3 bg-chatMint rounded-full animate-pulse"></div>
    </div>

    <div id="chat-container"
        class="fixed bottom-24 right-5 w-[380px] h-[520px] bg-white rounded-2xl shadow-chatFloating flex flex-col overflow-hidden scale-0 origin-bottom-right transition-all duration-700 ease-[cubic-bezier(0.34,1.56,0.64,1)] z-40 border border-chatShadow">
        <div class="chat-header p-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 fill-white">
                        <path
                            d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 0 1 7 7h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h1a7 7 0 0 1 7-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 0 1 2-2M7.5 13A2.5 2.5 0 0 0 5 15.5A2.5 2.5 0 0 0 7.5 18a2.5 2.5 0 0 0 2.5-2.5A2.5 2.5 0 0 0 7.5 13m9 0a2.5 2.5 0 0 0-2.5 2.5a2.5 2.5 0 0 0 2.5 2.5a2.5 2.5 0 0 0 2.5-2.5a2.5 2.5 0 0 0-2.5-2.5M9 3c-.55 0-1 .45-1 1s.45 1 1 1s1-.45 1-1s-.45-1-1-1m6 0c-.55 0-1 .45-1 1s.45 1 1 1s1-.45 1-1s-.45-1-1-1z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">AI Assistant</h3>
                    <div class="flex items-center text-white/80">
                        <span class="inline-block h-2 w-2 bg-chatMint rounded-full mr-2 animate-pulse"></span>
                        <p class="text-xs">Online</p>
                    </div>
                </div>
            </div>
            <div id="close-chat"
                class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center cursor-pointer hover:bg-white/30 transition-colors ripple-effect">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
        </div>

        <div id="chat-body" class="flex-1 p-4 overflow-y-auto bg-chatClouds">
            <div class="message-container flex flex-col">
                <div
                    class="chat-message chat-bubble bot-message bg-chatBubbleBot rounded-[18px] rounded-bl-[5px] max-w-[80%] p-3.5 mb-4 self-start mr-auto shadow-chatMessage pop-animation message-shine text-xs">
                    Hello! I'm your AI assistant. How can I help you today?
                </div>
                <div id="typing-indicator"
                    class="hidden bg-gray-200 p-3 rounded-[18px] mb-4 w-fit self-start shadow-sm">
                    <span class="h-2 w-2 bg-gray-500 rounded-full inline-block mr-1 animate-typing"></span>
                    <span class="h-2 w-2 bg-gray-500 rounded-full inline-block mr-1 animate-typing"
                        style="animation-delay: 0.2s"></span>
                    <span class="h-2 w-2 bg-gray-500 rounded-full inline-block animate-typing"
                        style="animation-delay: 0.4s"></span>
                </div>
            </div>
        </div>

        <div class="p-3 bg-white flex items-center border-t border-chatShadow shadow-chatInset">
            <input id="chat-input" type="text" placeholder="Type your message here..."
                class="chat-input flex-1 py-3 px-4 border border-chatShadow rounded-full outline-none text-sm focus:border-chatLavender transition-all">
            <button id="send-button"
                class="bg-chatIndigo text-white rounded-full w-11 h-11 ml-2 flex justify-center items-center transition-all duration-300 hover:bg-chatLavender active:scale-90 shadow-md ripple-effect">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-white">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                </svg>
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatBotIcon = document.getElementById('chat-bot-icon');
            const chatContainer = document.getElementById('chat-container');
            const closeChat = document.getElementById('close-chat');
            const chatInput = document.getElementById('chat-input');
            const sendButton = document.getElementById('send-button');
            const chatBody = document.getElementById('chat-body');
            const typingIndicator = document.getElementById('typing-indicator');

            chatBotIcon.addEventListener('click', function() {
                chatBotIcon.classList.remove('animate-bounce');
                chatBotIcon.classList.add('animate-rotate');

                setTimeout(() => {
                    chatContainer.classList.remove('scale-0');
                    chatContainer.classList.add('scale-100', 'transform');
                    chatBotIcon.classList.add('scale-0', 'opacity-0');
                    chatInput.focus();
                }, 300);
            });

            closeChat.addEventListener('click', function() {
                chatContainer.classList.remove('scale-100');
                chatContainer.classList.add('scale-0');

                setTimeout(() => {
                    chatBotIcon.classList.remove('scale-0', 'opacity-0', 'animate-rotate');
                    chatBotIcon.classList.add('animate-bounce', 'scale-100', 'opacity-100');
                }, 300);
            });

            function sendMessage() {
                const message = chatInput.value.trim();
                console.log(message)

                if (message !== '') {
                    addMessage(message, 'user');
                    chatInput.value = '';

                    typingIndicator.classList.remove('hidden');
                    typingIndicator.classList.add('flex');
                    chatBody.scrollTop = chatBody.scrollHeight;

                    getBotResponse(message).then(botResponse => {
                        typingIndicator.classList.add('hidden');
                        typingIndicator.classList.remove('flex');
                        addMessage(botResponse, 'bot');
                    }).catch(error => {
                        console.error("Error getting response:", error);
                        typingIndicator.classList.add('hidden');
                        typingIndicator.classList.remove('flex');
                        addMessage("Sorry, I couldn't process your request at the moment.", 'bot');
                    });
                }
            }

            function addMessage(message, sender) {
                const messageElement = document.createElement('div');
                messageElement.classList.add('chat-message', 'p-3.5', 'mb-4', 'max-w-[80%]', 'rounded-[18px]',
                    'shadow-message', 'pop-animation', 'text-xs');

                if (sender === 'user') {
                    messageElement.classList.add('user-message', 'bg-messageUser', 'rounded-br-[5px]', 'self-end',
                        'ml-auto');
                } else {
                    messageElement.classList.add('bot-message', 'bg-messageBot', 'rounded-bl-[5px]', 'self-start',
                        'mr-auto', 'message-shine');
                }

                messageElement.textContent = message;

                const messageContainer = document.querySelector('.message-container');
                messageContainer.insertBefore(messageElement, typingIndicator);

                chatBody.scrollTop = chatBody.scrollHeight;
            }
            
            async function getBotResponse(message) {
                const prompt = `You are HealthGate's AI medical assistant designed to work within our patient portal. Be concise, professional, and medically accurate while maintaining a helpful tone.

                                    RESPONSE GUIDELINES:
                                    1. Keep responses under 40 words for general inquiries
                                    2. First-time greeting: "Hi! How can I help with your health today?"
                                    3. Appointment requests: "Please schedule appointments through the Appointments section in your patient dashboard."
                                    4. Specialist inquiries: Only reference our available departments: Cardiology, Neurology, Dermatology, Pediatrics, Orthopedics, Gynecology, Ophthalmology
                                    5. Medical records: "Your medical history is available in the Health Metrics section of your dashboard."
                                    6. For prescription inquiries: "Your current medications and prescriptions can be viewed in the Prescriptions tab."
                                    7. For vital sign questions: Direct patients to check their latest measurements (heart rate, blood pressure, blood sugar) in the health metrics section
                                    8. For non-medical topics: "I'm designed to assist with health-related questions. How can I help with your medical needs today?"

                                    CONDITION-SPECIFIC GUIDELINES:
                                    1. For symptom questions: Provide brief, factual information with a concise disclaimer for potentially serious conditions
                                    2. For disease inquiries: Only provide general information about viral, bacterial, fungal, and parasitic conditions in our database
                                    3. When discussing treatments: Remind patients to consult with their assigned doctor before making any changes

                                    FORMATTING:
                                    - Use plain text only - no emojis, bold formatting, or other styling
                                    - Avoid unnecessary disclaimers or lengthy explanations
                                    - Focus on actionable information that directs patients to the appropriate section of their dashboard

                                    Patient message: ${message}`;
                alert(prompt);

                let reponse = await fetch("https://openrouter.ai/api/v1/chat/completions", {
                    method: "POST",
                    headers: {
                        "Authorization": "Bearer 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",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        "model": "deepseek/deepseek-chat-v3-0324:free",
                        "messages": [{
                            "role": "user",
                            "content": prompt
                        }]
                    })
                });

                let data = await reponse.json()
                console.log(data.choices[0].message.content)
                return data.choices[0].message.content;
            }

            sendButton.addEventListener('click', sendMessage);

            chatInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });
        });
    </script>
</body>

</html>
