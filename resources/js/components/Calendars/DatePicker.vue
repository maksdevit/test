<template>
  <div>
    <label :for="datepicker.id">
      {{ datepicker.title }}
    </label>
    <b-form-datepicker
        :id="datepicker.id"
        v-model="value"
        class="mt-2"
        @input="$emit('change', value)"
    />
    <p v-if="datepicker.messageDate !== null">{{ datepicker.messageDate }}</p>
  </div>
</template>

<script>
export default {
  name: "Home",
  props: {
    datepicker: Object,
  },
};
</script>
