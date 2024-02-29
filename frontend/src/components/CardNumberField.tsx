import { Stack, TextField } from '@mui/material'

export const CardNumberField = () => {
    return (
        <Stack sx={{marginTop: 2}}>
            <Stack direction={'row'} spacing={202}>
                <TextField id='card-number-id' label='Numero do cartao' />
            </Stack>
        </Stack>
    )
}