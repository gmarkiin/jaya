import { create } from "zustand";
import { CardData } from "./types";

const initialState: CardData = {
  cardId: "",
  cardNumber: "",
  cardholderName: "",
  identificationType: "",
  identificationNumber: "",
  securityCode: "",
  cardExpirationMonth: "",
  cardExpirationYear: "",
};

interface CardStore {
  cardData: CardData;
  updateField: (fieldName: string, value: string) => void;
  resetForm: () => void;
}

const useCardStore = create<CardStore>((set) => ({
  cardData: { ...initialState },
  updateField: (fieldName, value) =>
    set((state) => ({
      cardData: {
        ...state.cardData,
        [fieldName]: value,
      },
    })),
  resetForm: () =>
    set(() => ({
      cardData: { ...initialState },
    })),
}));

export default useCardStore;
