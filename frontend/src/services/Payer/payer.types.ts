import { IdentificationType } from "@mercadopago/sdk-react/coreMethods/getIdentificationTypes/types";

export interface PayerServiceMethods {
  getIdentificationTypes: () => Promise<IdentificationType[] | undefined>;
}
