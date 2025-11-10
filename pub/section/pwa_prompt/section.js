//PWA INSTALL
const installButton = document.getElementById('btn_install_pwa'); 
if (installButton != null){
    installButton.addEventListener('click', async () => {
        console.log('👍', 'butInstall-clicked');
        const promptEvent = deferredPrompt; // Use local variable instead
        if (!promptEvent) {
            console.log('❌', 'deferredPrompt is not available');
            return;
        }
        // Show the install prompt.
        promptEvent.prompt();
        // Log the result
        const result = await promptEvent.userChoice;
        console.log('👍', 'userChoice', result);
        // Reset the deferred prompt variable
        deferredPrompt = null;
        window.deferredPrompt = null;
        // Disable the install button.
        installButton.disabled = true;
    });
}

window.addEventListener('load', () => {
   if (window.matchMedia('(display-mode: standalone)').matches) {
        console.log('👍', 'display-mode is standalone');
    }

    console.log('🔍 Checking PWA readiness...');
    
    // Check if service worker is registered
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.getRegistrations().then(registrations => {
            console.log('📱 Service Workers:', registrations.length > 0 ? 'Found' : 'None');
        });
    }
    
    // Check for manifest
    const manifestLink = document.querySelector('link[rel="manifest"]');
    console.log('📋 Manifest:', manifestLink ? 'Found' : 'Missing');
    
    // Check HTTPS
    console.log('🔒 HTTPS:', location.protocol === 'https:' ? 'Yes' : 'No');
    
    // Check if already in standalone mode
    console.log('📱 Standalone:', window.matchMedia('(display-mode: standalone)').matches ? 'Yes' : 'No');
});
