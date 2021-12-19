<template>
    <div class="message" >
       {{ message.user.name }}: {{ message.message}} [{{ message.created_at}} ]
    </div>
</template>

<script>
    export default {
        // name: 'chat-component',
        props: ['message'],
        mounted() {
            console.log('Component selection chat chat mounted.')
        }
    }
</script>
