import { getInstallments } from "@mercadopago/sdk-react";
import { CardServiceMethods } from "./card.types";

const CardService: CardServiceMethods = {
  fetchInstallments: (params) => {
    return getInstallments(params);
  },
};

export default CardService;
