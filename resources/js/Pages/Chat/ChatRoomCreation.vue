<template>
    <div class="container" style="margin-bottom: 30px;">
       <h3>Chat Room Creation</h3>
        <div class="grid grid-cols-2" >
            <div class="font-bold">
                Chat Room Creating
            </div>
            <div class="all_rooms" style="height: 100px; border: 1px solid; overflow:scroll;">
                <ul
                    class="float-right">
                    <li v-for="(room, index) in rooms"
                        :key="index" :value="room"
                    >
                        {{ room.name}}
                    </li>
                </ul>
            </div>
            <input type="text"
                   v-model="room"
                   class="col-span-5 outline-none p-1">
            <button @click="createRoom()" class="place-self-end bg-gray-500 hover:bg-blue-700 p-1 mt-1 text-white" >Create room</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['rooms'],
        data: function (){
            return {
                room: '',
            }
        },
        methods: {
            createRoom() {
                if ( this.room == '') {
                    return;
                }
                axios.post('/chat/rooms/create', {
                    room: this.room
                })
                    .then( response => {
                        if ( response.status == 201) {
                            this.room = '';
                            this.$emit('roomcreated');
                        }
                    })
                    .catch( error =>
                        console.log('errror chat room created')
                    )
            }
        },
        mounted() {
            console.log('Room creation Input')
        }
    }
</script>
