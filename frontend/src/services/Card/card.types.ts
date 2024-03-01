import {
  Installments,
  InstallmentsParams,
} from "@mercadopago/sdk-react/coreMethods/getInstallments/types";

export interface CardServiceMethods {
  fetchInstallments: (
    params: InstallmentsParams
  ) => Promise<Installments[] | undefined>;
}
