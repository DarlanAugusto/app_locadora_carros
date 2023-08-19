<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th v-for="th, key in headers" :key="key">{{ th.title }}</th>

                <th v-if="show || update || remove"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in data" :key="item.id">
                <td v-for="attr, key in headers" :key="key + item.id">
                    <img v-if="attr.type == 'file'" :src="'/storage/' + item[key]" width="25">
                    <span v-else-if="attr.type == 'date'">{{ item[key] }}</span>
                    <span v-else>{{ item[key] }}</span>
                </td>

                <td class="text-right" v-if="show || update || remove">
                    <div class="d-flex justify-content-between">
                        <button
                            class="text-primary btn btn-link"
                            type="button"
                            v-if="show"
                            data-bs-toggle="modal"
                            :data-bs-target="'#' + idShowItemModal">

                            <i class="bi bi-eye-fill"/>
                        </button>
                        <i v-if="update" class="bi bi-pencil-square text-secondary btn btn-link"></i>
                        <i v-if="remove" class="bi bi-trash-fill text-danger btn btn-link"></i>
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
            'idShowItemModal'
        ],
    }
</script>
