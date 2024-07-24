<template>
    <div class="pagination justify-content-center">
        <button class="btn btn-primary" @click="previousPage" :disabled="currentPage === 1" style="margin: 1em;">
            {{ '<' }}
        </button>
        <span class="align-self-center"><b>Página {{ currentPage }} de {{ totalPages }}</b></span>
        <button class="btn btn-primary" @click="nextPage" :disabled="currentPage === totalPages" style="margin: 1em;">
            {{ '>' }}
        </button>
    </div>
    <br>
</template>

<script>
export default {
    props: {
        currentPage: {
            type: Number,
            required: true
        },
        totalPages: {
            type: Number,
            required: true
        }
    },
    methods: {
        previousPage() {
            if (this.currentPage > 1) {
                this.$emit('update-page', this.currentPage - 1);
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.$emit('update-page', this.currentPage + 1);
            }
        }
    }
};
</script>

<style scoped>
.pagination {
    text-align: center;
    margin-top: 20px;
}

button {
    margin: 0 5px;
}
</style>
