<template>
    <div class="form-inline item">
        <input type="hidden" :name="nameAttribute('id')" v-model="item.id">

        <div class="form-group">
            <v-select
                :options="options"
                :reduce="place => place.id"
                label="name"
                v-model="item.place_id"
                style="width: 520px"
                >

                <template slot="option" slot-scope="option">
                    {{ option.name }}<br>
                    <small>{{ option.address }}</small>
                </template>
            </v-select>

            <input type="hidden"
                v-model="item.place_id"
                :name="nameAttribute('place_id')"
            >
        </div>
        <div class="form-group">
            <label class="control-label" :for="idAttribute('day')">Data</label>
            <input size="10"
                placeholder="2019-01-01"
                class="form-control"
                v-model="item.created_at"
                :id="idAttribute('day')"
                :name="nameAttribute('day')"
            >
        </div>
        <div class="form-group">
            <input size="5"
                class="form-control"
                v-model="item.start"
                :id="idAttribute('start')"
                :name="nameAttribute('start')"
            >
            &ndash;
            <input size="5"
                class="form-control"
                v-model="item.end"
                :id="idAttribute('end')"
                :name="nameAttribute('end')"
            >
        </div>

        <div class="form-group">
            <label class="control-label" :for="idAttribute('marrow')">
            <input type="checkbox"
                v-model="item.marrow"
                :id="idAttribute('marrow')"
                :name="nameAttribute('marrow')"
            >
            Szpik</label>
            <br>
            <small><label class="control-label" :for="idAttribute('hidden')">
            <input type="checkbox"
                v-model="item.hidden"
                :id="idAttribute('hidden')"
                :name="nameAttribute('hidden')"
            >
            Ukryj</label></small>
        </div>

        <div class="form-group delete-button">
            <button class="btn btn-default btn-sm"
                :disabled="!item.can_remove"
                @click.prevent="remove"
            >
                X
            </button>
        </div>
    </div>
</template>
<script>

export default {
    computed: {
        idAttribute() {
            return (field) => "action-" + this.index + "-" + field;
        },

        nameAttribute() {
            return (field) => "action[" + this.index + "][" + field + "]";
        },

        options() {
            return window.placeList
        }
    },

    props: {
        item: Object,
        index: Number,
    },

    methods: {
        remove() {
            this.$emit('remove', { item: this.item, index: this.index })
        }
    }
}
</script>
