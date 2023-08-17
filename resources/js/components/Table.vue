<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th v-for="th in headers" :key="th" class="text-capitalize">{{ th }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in data" :key="item.id">
                <td v-for="attr in headers" :key="attr + item.id">
                    <img v-if="attr == 'imagem'" :src="'/storage/' + item[attr]" width="25">
                    <span v-else>{{ item[attr] }}</span>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['headers', 'data']
    }
</script>
