import { getIdentificationTypes } from "@mercadopago/sdk-react";
import { PayerServiceMethods } from "./payer.types";

const PayerService: PayerServiceMethods = {
  getIdentificationTypes: () => {
    return getIdentificationTypes();
  },
};

export default PayerService;
