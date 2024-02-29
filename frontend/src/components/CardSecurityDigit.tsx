import { Stack, TextField } from '@mui/material'

export const CardSecurityDigit = () => {
    return (
        <Stack sx={{marginTop: 2}}>
            <Stack direction={'row'} spacing={202}>
                <TextField label='Numero do cartao' />
            </Stack>
        </Stack>
    )
}