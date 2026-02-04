<script setup lang="ts">
import Toast from "@/components/Notification/Toast.vue";
import { useEmpresasStore } from "@/stores/empresas";
import { ref } from "vue";

const empresaStore = useEmpresasStore();

const nombre = ref<string>("");
const cif = ref<string>("");
const telefono = ref<number>(0);
const email = ref<string>("");
const direccion = ref<string>("");

async function agregarEmpresa() {
  let ok = false;

  ok = await empresaStore.createEmpresa(
    nombre.value,
    cif.value,
    telefono.value,
    email.value,
    direccion.value,
  );

  if (ok) {
    resetForms();
  }
}

function resetForms() {
  nombre.value = "";
  cif.value = "";
  telefono.value = 0;
  email.value = "";
  direccion.value = "";
}
</script>

<template>
  <h2>NUEVA EMPRESA</h2>
  <hr />
  <Toast
    v-if="empresaStore.message"
    :message="empresaStore.message"
    :messageType="empresaStore.messageType"
  />
  <form @submit.prevent="agregarEmpresa" class="row-cols-1">
    <div class="mb-3 col-2">
      <label for="cif" class="form-label">CIF:</label>
      <input
        type="text"
        class="form-control"
        placeholder="A12345678"
        v-model="cif"
        aria-label="Cif"
        id="cif"
        pattern="^[A-Z]\d{8}$"
        required
      />
    </div>

    <div class="mb-3 col-5">
      <label for="nombre" class="form-label">Nombre:</label>
      <input
        type="text"
        class="form-control"
        placeholder="Empresa S.A"
        v-model="nombre"
        aria-label="nombre"
        pattern="^[A-ZÁÉÍÓÚÑ][A-Za-zÁÉÍÓÚÑáéíóúñ.\s]*$"
        id="nombre"
        required
      />
    </div>

    <div class="mb-3 col-2">
      <label for="telefono" class="form-label">Telefono:</label>
      <input
        type="tel"
        class="form-control"
        placeholder="945 000 000"
        v-model="telefono"
        pattern="^\d{9}$"
        aria-label="Telefono"
        id="telefono"
        required
      />
    </div>

    <div class="mb-3 col-4">
      <label for="email" class="form-label">Email de contacto:</label>
      <input
        type="email"
        class="form-control"
        placeholder="contacto@empresa.com"
        v-model="email"
        aria-label="email"
        id="email"
      />
    </div>

    <div class="mb-3 col-5">
      <label for="direccion" class="form-label">Dirección:</label>
      <input
        type="text"
        class="form-control"
        placeholder="Calle empresa nº2, Edificio..."
        v-model="direccion"
        aria-label="Direccion"
        id="direccion"
        required
      />
    </div>

    <button type="submit" class="btn btn-primary col-2">Agregar</button>
  </form>
</template>

<style scoped></style>
