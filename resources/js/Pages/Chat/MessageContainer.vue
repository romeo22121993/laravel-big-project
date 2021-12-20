<template>
    <div class="container messages_box" style="height: 350px; overflow: scroll; border: 1px solid #000;" >
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
