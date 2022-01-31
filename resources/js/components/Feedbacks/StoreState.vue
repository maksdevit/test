<template>
  <div>
    <div v-if="messageStore">{{ messageStore }}</div>
    <div v-else>We're not sure when our store will be opened.</div>
  </div>
</template>

<script>
export default {
  name: "StoreState",
  props: {
    messageStore: String,
  },
};
</script>
