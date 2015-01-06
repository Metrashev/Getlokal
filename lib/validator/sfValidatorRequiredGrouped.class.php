<?php 
/**
 * Validates that at least one group has all values supplied
 *
 * groups options takes an array of grouped fields correponding to fields in the form
 * Accepts a string notation as the sfToolkit::getArrayValueForPath
 */
class sfValidatorRequiredGrouped extends sfValidatorBase
{

    public function configure($options = array(), $message = array()) 
    {
        $this->addRequiredOption('groups');
    }

    protected function doClean($value) 
    {
        $groups = $this->extractGroups($value);
        $valid = array();
        foreach ($groups as $group) {
            if ($this->isValidGroup($group)) {
                $valid[] = $group;
            }
        }
        
        if (empty($valid)) {
            throw new sfValidatorError($this, 'required');
        }

        return $value;
    }

    protected function isValidGroup($group)
    {
        foreach ($group as $v) {
            $v = trim($v);
            if (empty($v)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Gets the corresponding fields from the values and returns a mirror array 
     * with values in the same positions as in groups
     * 
     * @param array $values Array of values as received from the form
     * @return array
     */
    protected function extractGroups($values) 
    {
        $groups = array();

        foreach ($this->getOption('groups') as $g) {
            $group = array();
            foreach ($g as $f) {
                $group[] = sfToolkit::getArrayValueForPath($values, $f);
            }
            $groups[] = $group;
        }

        return $groups;
    }

}
