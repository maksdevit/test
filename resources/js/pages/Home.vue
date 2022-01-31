<template>
  <b-container>
    <b-row class="align-items-center">
      <b-col>
        <h2>Widget 1</h2>
        <DatePicker
            @change="fetchStoreStateByDate"
            :datepicker="{
                        title: 'Choose date',
                        id: 'datepicker',
                        messageDate,
                    }"
        />
      </b-col>
      <b-col>
        <h2>Widget 2</h2>
        <StoreState :messageStore="messageStore"/>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import axios from "axios";
import DatePicker from "@/components/Calendars/DatePicker";
import StoreState from "@/components/Feedbacks/StoreState";

export default {
  name: "Home",
  components: {
    DatePicker,
    StoreState,
  },
  data() {
    return {
      messageDate: null,
      messageStore: null,
    };
  },
  methods: {
    async fetchStoreStateByDate(date) {
      const storeState = await axios.get("/api/dates", {
        params: {date},
      });
      this.messageDate = storeState.data.message;
    },
  },
  async mounted() {
    const storeState = await axios.get("/api/status");
    this.messageStore = storeState.data.message;
  },
};
</script>
