import { startRegistration } from '@simplewebauthn/browser'
import './bootstrap'

import Alpine from 'alpinejs'

window.Alpine = Alpine

document.addEventListener('alpine:init', () => {
    Alpine.data('registerPasskey', () => ({
        name: '',
        errors: null,
        async register(form) {
            this.errors = null

            const options = await axios.get('/api/passkeys/register', {
                params: { name: this.name },
                validateStatus: (status) => [200, 422].includes(status),
            })

            if (options.status === 422) {
                this.errors = options.data.errors
                return
            }

            const passkey = await startRegistration(options.data)

            form.addEventListener('formdata', ({ formData }) => {
                formData.set('passkey', JSON.stringify(passkey))
            })

            form.submit()
        },
    }))
})

Alpine.start()
