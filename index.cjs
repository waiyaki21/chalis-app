const { app, BrowserWindow, dialog } = require('electron');
// const { autoUpdater } = require('electron-updater');
const path = require('path');
const fs = require('fs');
const phpServer = require('node-php-server');
const port = 8080, host = '127.0.0.1';
const serverUrl = `http://${host}:${port}`;

const phpPath = process.env.NODE_ENV === 'production'
    ? path.join(process.resourcesPath, 'php', 'php.exe')
    : path.join(__dirname, 'php', 'php.exe');

let mainWindow;

// Function to log errors to a file
function logErrorToFile(error) {
    const logPath = path.join(app.getPath('userData'), 'error.log');
    const logMessage = `${new Date().toISOString()} - ${error.stack || error}\n`;
    fs.appendFileSync(logPath, logMessage, 'utf8');
}

// Function to show error dialog
function showErrorDialog(errorMessage) {
    dialog.showErrorBox('An Error Occurred', errorMessage);
}

function createWindow() {
    console.log('PHP path:', phpPath); // Log PHP path for debugging

    try {
        // Create a PHP Server
        phpServer.createServer({
            port: 8080,
            hostname: '127.0.0.1',
            base: path.join(__dirname, 'public'),
            keepalive: false,
            open: false,
            bin: phpPath,
            router: path.join(__dirname, 'server.php')
        });
    } catch (error) {
        console.error('PHP server error:', error);
        showErrorDialog('Failed to start the PHP server. Please check the error log for details.');
        showErrorDialog(error); // Log the error to a file
    }

    mainWindow = new BrowserWindow({
        width: 1200,
        height: 720,
        center: true,
        autoHideMenuBar: true,
        icon: path.join(__dirname, 'chama_icon.png')
    });

    mainWindow.loadURL(serverUrl);

    mainWindow.webContents.once('dom-ready', function () {
        mainWindow.show();
    });

    mainWindow.on('closed', function () {
        phpServer.close();
        mainWindow = null;
    });
}

// Global error handling for unhandled exceptions
process.on('uncaughtException', (error) => {
    console.error('Uncaught Exception:', error);
    showErrorDialog('An unexpected error occurred. Please check the error log for details.');
    logErrorToFile(error);
});

app.whenReady().then(createWindow);

app.on('activate', () => {
    if (BrowserWindow.getAllWindows().length === 0) {
        createWindow();
    }
});

app.on('window-all-closed', () => {
    if (process.platform !== 'darwin') {
        app.quit();
    }
});
