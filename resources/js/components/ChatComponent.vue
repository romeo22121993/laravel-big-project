<template>
    <div class="container" >
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Chat Component</div>

                    <div class="card-body">
                        I'm an example component.
                        <input type="text" v-model="message" v-on:keyup="send">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'chat-component',
        mounted() {
            console.log('Component chat mounted.')
        }
    }
</script>
