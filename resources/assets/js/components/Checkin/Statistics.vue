<template>
    <section class="statistics">
        <div class="content">
            <h3>Dane statystyczne</h3>
            <div class="form-group">
                <label for="">Oddaję (pierwszy raz/kolejny raz)</label>
                <button type="button" class="btn btn-lg btn-toggle" data-toggle="button" aria-pressed="false" autocomplete="off">
                    <div class="handle"></div>
                </button>
            </div>

            <!-- has-error -->
            <div class="form-group">
                <label for="blood_type" class="control-label">Grupa krwi</label>
                <select name="blood_type" id="blood_type" class="form-control">
                    <option>---</option>
                    <option value="a_plus">A+</option>
                    <option value="a_minus">A-</option>
                    <option value="b_plus">B+</option>
                    <option value="b_minus">B-</option>
                    <option value="ab_plus">AB+</option>
                    <option value="ab_minus">AB-</option>
                    <option value="zero_plus">0+</option>
                    <option value="zero_minus">0-</option>
                    <option value="unknown">Nie wiem</option>
                </select>
            </div>

            <div class="form-group">
                <label class="control-label" for="size">Rozmiar koszulki</label>
                <select name="size" id="size" class="form-control">
                    <option v-for="(name, id) in tshirtSizes" :value="id">{{ name }}</option>
                </select>
             </div>
            <button type="button" v-on:click="nextStep()">yo</button>
        </div>
    </section>
</template>

<script>
    import { default as mixins } from './mixins';
    import { mapState } from 'vuex'

    export default {
        mixins: [mixins],

        computed: {
            ...mapState(['tshirtSizes'])
        },

        mounted() {
            console.log('Component ready.')
        }
    }
</script>
