import { startRegistration } from '@simplewebauthn/browser'
import './bootstrap'

import Alpine from 'alpinejs'

window.Alpine = Alpine

document.addEventListener('alpine:init', () => {
    Alpine.data('registerPasskey', () => ({
        register: async () => {
            const options = await axios.get('/api/passkeys/register')
            const passkey = await startRegistration(options.data)

            console.log(passkey)
        },
    }))
})

Alpine.start()
