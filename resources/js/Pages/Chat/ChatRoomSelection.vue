<template>
    <div class="container" >
       <h3>Chat Room Selection</h3>
        <div class="grid grid-cols-2" >
            <div class="font-bold">
                {{ selected.name }} Chat
            </div>
            <div>
                <select
                    v-model="selected"
                    @change="$emit('roomchanged', selected)"
                    class="float-right">
                    <option v-for="(room, index) in rooms"
                        :key="index" :value="room"
                    >
                        {{ room.name}}
                    </option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        // name: 'chat-component',
        props: ['rooms', 'currentRoom'],
        data: function (){
            return {
                selected: '',
            }
        },
        created() {
            this.selected = this.currentRoom;
        },
        mounted() {
            console.log('Component selection chat chat mounted.')
        }
    }
</script>
