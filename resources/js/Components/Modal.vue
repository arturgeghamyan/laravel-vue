<template>
  <div class="modal">
    <button class="close" @click="$emit('close')">x</button>
    <div class="body">
        <slot />
    </div>
  </div>
</template>

<style>
 .overlay {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
}

 .modal {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  width: 350px;
  height:200px;
  z-index: 9999;
  margin: auto;
  padding: 20px 30px;
  background-color: #fff;
}

.close{
  position: absolute;
  top: 10px;
  right: 10px;
}
</style>