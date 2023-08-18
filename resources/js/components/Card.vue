<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" v-if="header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>.: {{ header }}</div>
                            <slot name="headerActions"></slot>
                        </div>
                    </div>
                    <div class="card-body"><slot name="body" /></div>
                    <div class="card-footer"><slot name="footer" /></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['header', 'footer']
    }
</script>
