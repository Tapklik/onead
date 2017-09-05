<template id="modal-box-template">
    <div @click="closeModal" v-show="isModalOpen" class="Modal u-overlay">
        <div @click.stop="" v-show="isModalOpen" class="Modal__container">
            <header class="Modal__header">
                <h1>
                    @{{ title }}
                </h1>
            </header>

            <div class="Modal__content">
                <slot></slot>
            </div>

            <footer class="Modal__footer"></footer>
        </div>
    </div>
</template>