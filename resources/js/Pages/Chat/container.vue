<template>
    <div class="container" id='app'>
        <h3>Chat</h3>
        <chat-room-selection
            :rooms="chatRooms"
            :currentRoom="currentRoom"
            v-on:roomchanged="setRoom($event)"
        ></chat-room-selection>
        <message-container :messages="messages" v-on:messagesent="setRoom(currentRoom)"></message-container>
        <input-message :room="currentRoom"
           v-on:messagesent="getMessages()"
        ></input-message>
    </div>
</template>
<script>
    import MessageContainer from "./MessageContainer";
    import InputMessage from "./InputMessage";
    import ChatRoomSelection from "./ChatRoomSelection";
    export default {
        components: {ChatRoomSelection, InputMessage, MessageContainer},
        // name: 'chat-component',
        mounted() {
            this.getRooms();
            console.log('Component chat mounted.')
        },
        data: function () {
            return {
                chatRooms: [],
                currentRoom: [],
                messages: [],
            }
        },
        watch: {
            currentRoom( val, oldVal) {
                if ( oldVal.id) {
                    this.disconnect(oldVal);
                }
                this.connect();
            }
        },
        methods: {
            connect() {
                if ( this.currentRoom.id) {
                    let vm = this;
                    this.getMessages();

                    window.Echo.private('chat.'+this.currentRoom.id)
                        .listen('.message.new', e => {
                            vm.getMessages();
                        });
                }
            },
            disconnect(room) {
                window.Echo.leave("chat."+this.currentRoom.id)
            },
            getRooms() {
                axios.get('/chat/rooms')
                .then( response => {
                    console.log('first', response.data[0])
                    this.chatRooms = response.data;
                    this.setRoom(response.data[0]);
                } )
                .catch( error =>
                    console.log('error1')
                )
            },
            setRoom( room ){
                this.currentRoom = room;
                this.getMessages();
            },
            getMessages() {
                axios.get('/chat/rooms/' + this.currentRoom.id + '/messages')
                .then( response => {
                    this.messages = response.data;
                })
                .catch( error =>
                    console.log('error2')
                )
            },
        },
        created(){
            this.getRooms();
        }
    }
</script>
