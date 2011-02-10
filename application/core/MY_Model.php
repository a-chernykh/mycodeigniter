<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {
  protected static $cached_field_names = array();
  
  protected $primary_key = 'id';
  protected $fields = array();
  protected $values = array();
  
  public function __construct()
  {
    parent::__construct();
    if (get_class($this) != 'MY_Model' && !empty($this->table_name))
    {
      $this->load_fields();
    }
  }
  
  public function __get($key)
  {
    if ($this->field_exists($key))
    {
      return $this->get($key);
    }
    return parent::__get($key);
  }
  
  public function __set($key, $value)
  {
    if ($this->field_exists($key))
    {
      $this->set($key, $value);
    }
  }
  
  public function __call($name, $params)
  {
    /**
     * Dynamic finders:
     *
     * find_by_id(...)
     * find_by_name(...)
     * find_by_any_fieldname(...)
     * find_first_by_id(...)
     * find_first_by_name(...)
     * find_first_by_any_field(...)
     *
     * The function returns one record in case of "first" query
     */
    if (preg_match('/^find(_first)?_by_(?<field>.+)/i', $name, $matches))
    {
      $first = preg_match('/^find_first_by_(?<field>.+)/i', $name);
      $field = $this->unify_field_name($matches['field']);
      if ($this->field_exists($field))
      {
        $this->db->where($field, $params[0]);
        if ($first)
        {
          $this->db->limit(1);
        }
        $query = $this->db->get($this->table_name);
        if ($first)
        {
          return self::load($query->row());
        } else
        {
          $results = array();
          foreach($query->result() as $row)
          {
            $results[] = self::load($row);
          }
          return $results;
        }
      }
    }
  }
  
  public function create($data)
  {
    unset($data[$this->primary_key]);
    $model = $this->load($data);
    $model->save();
    return $model;
  }
  
  /**
   * Save or update the record depending if it's new or not
   * @return TRUE or FALSE on success and failure respectively
   */
  public function save()
  {
    // Prepare the data for DB operation
    $data = array();
    foreach(array_values($this->fields) as $field)
    {
      if ($value = $this->get($field))
      {
        $data[$field] = $value;
      }
    }
    
    if ($this->get($this->primary_key))
    {
      // Existing record, updating
      $this->db->where($this->primary_key, $this->get($this->primary_key));
      if ($this->db->update($this->table_name, $data))
      {
        return TRUE;
      } else
      {
        return FALSE;
      }
    } else
    {
      // New record, inserting
      if ($this->db->insert($this->table_name, $data))
      {
        $this->set($this->primary_key, $this->db->insert_id());
        return TRUE;
      } else
      {
        return FALSE;
      }
    }
  }
  
  /**
   * Loads the fields data from the object or array
   * @param mixed The data, object or array
   * @return The new instance of the current model with the loaded fields
   */
  public function load($data)
  {
    $class = get_class($this);
    $model = new $class;
    foreach($data as $k => $v)
    {
      $model->set($k, $v);
    }
    return $model;
  }
  
  /**
   * Sets the field value
   * @param string The field name
   * @param mixed Value
   * @return Returns the new value or FALSE if field does not exists
   */
  public function set($field, $value)
  {
    $field = $this->unify_field_name($field);
    if ($this->field_exists($field))
    {
      return ($this->values[$field] = $value);
    }
    return FALSE;
  }
  
  /**
   * Get the field value
   * @param string The field name
   * @return Returns the value of the field or FALSE if the field does not exists
   */
  public function get($field)
  {
    $field = $this->unify_field_name($field);
    if ($this->field_exists($field) && !empty($this->values[$field]))
    {
      return $this->values[$field];
    } else
    {
      return FALSE;
    }
  }
  
  /**
   * Determine if the field is exists.
   * @param string The name of the field
   * @return boolean
   */
  protected function field_exists($field)
  {
    return in_array($field, $this->fields);
  }
  
  /**
   * Unifies the field name
   * @param string The name of the field
   * @return The unified name of the field
   */
  protected function unify_field_name($field)
  {
    return strtolower($field);
  }
  
  /**
   * Load the table fields from the database.
   * @return boolean Always returns TRUE value
   */
  protected function load_fields()
  {
    if (empty(self::$cached_field_names[$this->table_name]))
    {
      $this->fields = array();
      $fields = $this->db->list_fields($this->table_name);
      foreach($fields as $field)
      {
        $this->fields[] = $field;
      }
      self::$cached_field_names[$this->table_name] = $this->fields;
    } else
    {
      $this->fields = self::$cached_field_names[$this->table_name];
    }
    return TRUE;
  }
}

/* End of file MY_Model.php */
/* Location: ./application/libraries/MY_Model.php */