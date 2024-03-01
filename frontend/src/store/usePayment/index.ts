import { create } from "zustand";
import { PaymentData } from "./types";
import { set as customSet } from "lodash";

const initialState: PaymentData = {
  transactionAmount: 0,
  installments: 0,
  token: "",
  paymentMethodId: "",
  identificationTypes: [],
  payer: {
    email: "",
    identification: {
      type: "",
      number: "",
    },
  },
};

interface PaymentStore {
  paymentData: PaymentData;
  updateField: (fieldName: string, value: string | unknown) => void;
  resetForm: () => void;
}

const usePaymentStore = create<PaymentStore>((set) => ({
  paymentData: { ...initialState },
  identificationTypes: [],
  updateField: (fieldPath, value) =>
    set((state) => {
      const newState = { ...state.paymentData };
      customSet(newState, fieldPath, value);

      return { paymentData: newState };
    }),
  resetForm: () =>
    set(() => ({
      paymentData: { ...initialState },
    })),
}));

export default usePaymentStore;
