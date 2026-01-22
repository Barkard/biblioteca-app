const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcode = require('qrcode-terminal');
const express = require('express');
const app = express();
const port = 3001;

app.use(express.json());
app.use(express.urlencoded({ extended: true }));

console.log('Iniciando Cliente de WhatsApp...');

const client = new Client({
    authStrategy: new LocalAuth(),
    puppeteer: {
        headless: true,
        args: [
            '--no-sandbox',
            '--disable-setuid-sandbox',
            '--disable-dev-shm-usage',
            '--disable-accelerated-2d-canvas',
            '--no-first-run',
            '--no-zygote',
            '--disable-gpu'
        ]
    }
});

client.on('qr', (qr) => {
    console.log('ESCANEA ESTE CODIGO QR CON EL WHATSAPP DE LA BIBLIOTECA:');
    qrcode.generate(qr, { small: true });
});

client.on('ready', () => {
    console.log('¡WhatsApp está listo y conectado!');
    console.log('Esperando peticiones de Laravel en el puerto ' + port);
});

client.on('auth_failure', msg => {
    console.error('Fallo de autenticación', msg);
});

client.initialize();

// Endpoint que llamará Laravel
// POST http://localhost:3001/send
// Body: { "number": "58414...", "message": "Hola..." }
app.get('/send', async (req, res) => {
    const phone = req.query.phone;
    const message = req.query.message;

    if (!phone || !message) {
        return res.status(400).json({ error: 'Faltan datos (phone o message)' });
    }

    try {
        // Formatear numero: 58414XXXXXXX -> 58414XXXXXXX@c.us
        const chatId = phone.replace('+', '') + "@c.us";
        
        // Verificar si el numero esta registrado en WhatsApp
        const isRegistered = await client.isRegisteredUser(chatId);
        if (!isRegistered) {
             return res.status(404).json({ error: 'El numero no esta registrado en WhatsApp' });
        }

        // Enviar mensaje
        await client.sendMessage(chatId, message);
        console.log(`Mensaje enviado a ${phone}`);
        
        res.json({ status: 'success', message: 'Mensaje enviado' });
    } catch (error) {
        console.error('Error enviando mensaje:', error);
        res.status(500).json({ status: 'error', error: error.message });
    }
});

app.listen(port, () => {
    console.log(`Servidor Gateway escuchando en http://localhost:${port}`);
});
