import './bootstrap'

import Alpine from 'alpinejs'

window.Alpine = Alpine

document.addEventListener('alpine:init', () => {
    Alpine.data('registerPasskey', () => ({
        register: async () => {
            const options = await axios.get('/api/passkeys/register')
            console.log(options.data)
        },
    }))
})

Alpine.start()
