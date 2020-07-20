<template>
  <div :class="`text-${field.textAlign}`">
    <boolean-icon :value="field.value" />
  </div>
</template>

<script>

import BooleanIcon from './BooleanIcon.vue';
export default {
  props: ['resourceName', 'field'],
  components: {BooleanIcon}
}
</script>
