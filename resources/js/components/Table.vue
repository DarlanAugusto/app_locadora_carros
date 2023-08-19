<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th v-for="th, key in headers" :key="key">{{ th.title }}</th>

                <th v-if="show.visible || update.visible || remove.visible"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in data" :key="item.id">
                <td v-for="attr, key in headers" :key="key + item.id">
                    <img v-if="attr.type == 'file'" :src="'/storage/' + item[key]" width="25">
                    <span v-else-if="attr.type == 'date'">{{ item[key] }}</span>
                    <span v-else>{{ item[key] }}</span>
                </td>

                <td class="text-right" v-if="show.visible || update.visible || remove.visible">
                    <div class="d-flex justify-content-between">
                        <button
                            class="text-primary btn btn-link"
                            type="button"
                            v-if="show.visible"
                            data-bs-toggle="modal"
                            :data-bs-target="show.target"
                            @click="setStore(item)"
                            >

                            <i class="bi bi-eye-fill"/>
                        </button>


                        <button
                            class="text-secondary btn btn-link"
                            type="button"
                            v-if="update.visible"
                            data-bs-toggle="modal"
                            :data-bs-target="update.target"
                            @click="setStore(item)">

                            <i class="bi bi-pencil-square"></i>
                        </button>

                        <button
                            class="text-danger btn btn-link"
                            type="button"
                            v-if="remove.visible"
                            data-bs-toggle="modal"
                            :data-bs-target="remove.target"
                            @click="setStore(item)">

                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: [
            'headers',
            'data',
            'update',
            'show',
            'remove',
        ],
        methods: {
            setStore(item) {

                this.$store.state.status = '';
                this.$store.state.statusMessage = [];
                this.$store.state.item = item;
            }
        }
    }
</script>
