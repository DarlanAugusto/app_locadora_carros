<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th v-for="th, key in headers" :key="key">{{ th.title }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in data" :key="item.id">
                <td v-for="attr, key in headers" :key="key + item.id">
                    <img v-if="attr.type == 'file'" :src="'/storage/' + item[key]" width="25">
                    <span v-else-if="attr.type == 'date'">{{ item[key] }}</span>
                    <span v-else>{{ item[key] }}</span>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['headers', 'data'],
    }
</script>
