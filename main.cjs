const { app, BrowserWindow, dialog }  = require('electron');
const { autoUpdater }         = require('electron-updater'); // Import autoUpdater
const path                    = require('path');
var phpServer                 = require('node-php-server');
const port = 8000, host = '127.0.0.1';
const serverUrl               = `http://${host}:${port}`;

// Set up the PHP path conditionally
const phpPath = process.env.NODE_ENV === 'production'
  ? path.join(process.resourcesPath, 'php', 'php.exe')  // Path for production
  : path.join(__dirname, 'php', 'php.exe');             // Path for development

let mainWindow

// Function to show error dialog
function showErrorDialog(errorMessage) {
    dialog.showErrorBox('An Error Occurred', errorMessage);
}

function createWindow() {
  // Log the PHP path for debugging
  console.log('PHP path:', phpPath);
  
  try {
    // Create a PHP Server
    phpServer.createServer({
      port: 8000,
      hostname: '127.0.0.1',
      base: path.join(__dirname, 'public'),
      keepalive: false,
      open: false,
      bin: 'php',
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
    autoHideMenuBar: false,
    icon: __dirname + './chama_icon.png'
  })

  mainWindow.loadURL(serverUrl)

  mainWindow.webContents.once('dom-ready', function () {
    mainWindow.show()
  });

  // Emitted when the window is closed.
  mainWindow.on('closed', function () {
    phpServer.close();
    mainWindow = null;
  });

  // Check for updates after the window is created
  autoUpdater.checkForUpdatesAndNotify();
}

// Auto-Updater Event Listeners
autoUpdater.on('update-available', () => {
  console.log('Update available. Downloading...');
});

autoUpdater.on('update-downloaded', (event, releaseNotes, releaseName) => {
  const dialogOpts = {
    type: 'info',
    buttons: ['Restart', 'Later'],
    title: 'Application Update',
    message: process.platform === 'win32' ? releaseNotes : releaseName,
    detail:
      'A new version has been downloaded. Restart the application to apply the updates.'
  }

  dialog.showMessageBox(dialogOpts).then((returnValue) => {
    if (returnValue.response === 0) autoUpdater.quitAndInstall()
  })
});

autoUpdater.on('error', (error) => {
  console.error('Error updating:', error);
});

app.whenReady().then(() => {
  createWindow();

  app.on('activate', () => {
    if (BrowserWindow.getAllWindows().length === 0) {
      createWindow();
    }
  });
});

app.on('window-all-closed', () => {
  if (process.platform !== 'darwin') {
    app.quit();
  }
});
