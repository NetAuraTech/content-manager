import {FieldComponent} from "../../types";
import {defineField} from "./utils";
import {ColorPicker} from "../ui/colorPicker";

export type ColorFieldArgs = {
    label?: string
    help?: string
    default?: string
    canAnimate?: boolean
}

const Component: FieldComponent<ColorFieldArgs, string | null> = ({
                                                                      value,
                                                                      onChange,
                                                                      options,
                                                                  }) => {

    return (
        <div className={"form-group color"}>
            <label>{options.label}</label>
            <ColorPicker
                value={value}
                onChange={onChange}
                options={options}
            />
        </div>
    )
}

export const Color = defineField<ColorFieldArgs, string | null>({
    defaultOptions: {
        default: '',
        colors: [] as string[],
        canAnimate: false,
    },
    render: Component,
})
