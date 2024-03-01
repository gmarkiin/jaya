import { IdentificationType } from "@mercadopago/sdk-react/coreMethods/getIdentificationTypes/types";

export type Option = {
  label: string;
  value: string;
};

export interface PaymentData {
  transactionAmount: number;
  installments: number;
  token: string;
  paymentMethodId: string;
  identificationTypes?: IdentificationType[];
  payer: {
    email: string;
    identification: {
      type: string;
      number: string;
    };
  };
}
