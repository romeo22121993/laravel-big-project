<template>
    <div class="container" >
       <h3>Message Input</h3>
        <input type="text"
               v-model="roman"
               class="col-span-5 outline-none p-1">
        <button @click="sendMessage()" class="place-self-end bg-gray-500 hover:bg-blue-700 p-1 mt-1 text-white" >Send</button>
    </div>
</template>

<script>
    export default {
        props: ['room'],
        data: function (){
            return {
                message: '',
                roman: '',
            }
        },
        methods: {
            sendMessage() {
                if ( this.roman == '') {
                    return;
                }
                axios.post('/chat/rooms/' + this.room.id + '/messages', {
                    message: this.roman
                })
                .then( response => {
                    if ( response.status == 201) {
                        this.roman = '';
                        this.$emit('messagesent');
                    }
                })
                .catch( error =>
                    console.log('errror here')
                )
            }
        },
        mounted() {
            console.log('Message Input')
        }
    }
</script>
