<template>
    <div class="container" >
       <h3>Message Container</h3>
        <div>
            <div v-for="(message, index) in messages" :key="index">
                <message-item :message="message"></message-item>
            </div>
        </div>

    </div>
</template>

<script>
    import MessageItem from "./MessageItem";
    export default {
        components: {MessageItem},
        props: ['messages'],
        // name: 'chat-component',
        mounted() {
            console.log('Component selection chat chat mounted.')
        }
    }
</script>
