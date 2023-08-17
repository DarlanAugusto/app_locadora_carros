<template>
        <div class="modal fade" :class="className" :id="id" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" :id="titleId">{{ title }}</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                            v-if="closeButton"
                        />
                    </div>
                    <div class="modal-body">
                        <slot name="modalAlert"/>
                        <slot name="modalBody"/>
                    </div>
                    <div class="modal-footer">
                        <slot name="modalFooter"/>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    props: {
        id: String,
        titleId: String,
        title: String,
        closeButton: Boolean,
        className: String,
    }
}
</script>
