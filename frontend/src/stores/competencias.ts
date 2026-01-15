import type { Competencia } from "@/interfaces/Competencia";
import { defineStore } from "pinia";
import { ref } from "vue";
import { useAuthStore } from "./auth";

export const useCompetenciasStore = defineStore("competencias", () => {
  const competencias = ref<Competencia[]>([]);
  const authStore = useAuthStore();
  const error = ref<string | null>(null);

  // Obtener todos las competencias
  async function fetchCompetencias() {
    const response = await fetch("http://localhost:8000/api/competencias", {
      headers: authStore.token
        ? {
            Authorization: `Bearer ${authStore.token}`,
            Accept: "application/json",
          }
        : {
            Accept: "application/json",
          },
    });

    const data = await response.json();
    console.log("Competencias recibidas:", data);
    competencias.value = data as Competencia[];
  }

  async function createCompetenciaTecnica(
    id_ciclo: number,
    descripcion: string,
  ) {
    const response = await fetch(
      "http://localhost:8000/api/competencia/tecnica",
      {
        method: "POST",
        headers: {
          Authorization: authStore.token ? `Bearer ${authStore.token}` : "",
          Accept: "application/json",
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ id_ciclo, descripcion }),
      },
    );

    const data = await response.json();

    if (!response.ok) {
      error.value = data.message || "Error desconocido, intentalo más tarde";
      setTimeout(() => {
        error.value = null;
      }, 5000);
      return false;
    } else {
    }
  }

  async function createCompetenciaTransversal(
    id_familia: number,
    descripcion: string,
  ) {
    const response = await fetch(
      "http://localhost:8000/api/competencia/transversal",
      {
        method: "POST",
        headers: {
          Authorization: authStore.token ? `Bearer ${authStore.token}` : "",
          Accept: "application/json",
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ id_familia, descripcion }),
      },
    );

    const data = await response.json();

    if (!response.ok) {
      error.value = data.message || "Error desconocido, intentalo más tarde";
      setTimeout(() => {
        error.value = null;
      }, 5000);
      return false;
    } else {
    }
  }

  return {
    competencias,
    fetchCompetencias,
    createCompetenciaTecnica,
    createCompetenciaTransversal,
  };
});
