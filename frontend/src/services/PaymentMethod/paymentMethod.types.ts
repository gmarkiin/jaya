import { PaymentMethods } from "@mercadopago/sdk-react/coreMethods/getPaymentMethods/types";

export interface PaymentMethodsServiceMethods {
  fetchPaymentMethods: (
    bin: string
  ) => Promise<PaymentMethods | undefined>;
}