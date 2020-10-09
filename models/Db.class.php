<?php
class Db
{
    private static $instance = null;
    private $_db;

    private function __construct()
    {
        try {
            $this->_db = new PDO('mysql:host=localhost;dbname=bdproject;charset=utf8', 'root', '');
            $this->_db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			      $this->_db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
        }
		catch (PDOException $e) {
		    die('Error while connecting to Database : '.$e->getMessage());
        }
    }

	# Pattern Singleton
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Db();
        }
        return self::$instance;
    }

    # SELECT SCRIPTS -----------------------------------------------------------
    # Function to select ONLY ONE student
    public function select_student($email){
    		$query = 'SELECT * FROM students WHERE student_mail='.$this->_db->quote($email);
    		$result = $this->_db->query($query);
    		$student = null;
    		if ($result->rowcount()!=0) {
    		    $row = $result->fetch();
    		    $student = new Student($row->student_mail,$row->serie_num,$row->name,$row->first_name,$row->block);
    		}
    return $student;
    }

  	# Function used to select students
  	# return objects from Student Class
  	public function select_students($block=''){
		if($block == ''){
			$query = 'SELECT * FROM students';
		} else {
			$query = 'SELECT * FROM students WHERE block='.$this->_db->quote($block);
		}
  		# Query execution
  		$result = $this->_db->query($query);
  		# Construct  a table of objects Student
  		$table = array();
  		if ($result->rowcount()!=0) {
  			while ($row = $result->fetch()) {
  				$table[] = new Student($row->student_mail,$row->serie_num,$row->name,$row->first_name,$row->block);
  			}
  		}
  		return $table;
  	}

    # function to select ONLY ONE teacher
    public function select_teacher($email){
        $query = 'SELECT * FROM teachers WHERE teacher_mail='.$this->_db->quote($email);
        $result = $this->_db->query($query);
        $teacher = null;
        if ($result->rowcount()!=0) {
            $row = $result->fetch();
            $teacher = new Teacher($row->teacher_mail,$row->name,$row->first_name,$row->responsability);
        }
    return $teacher;
    }

    # function to select ONLY ONE teacher
    public function select_admin(){
        $query = 'SELECT * FROM teachers WHERE responsability LIKE '.$this->_db->quote('%true%');
        $result = $this->_db->query($query);
        $teacher = null;
        if ($result->rowcount()!=0) {
            $row = $result->fetch();
            $teacher = new Teacher($row->teacher_mail,$row->name,$row->first_name,$row->responsability);
        }
    return $teacher;
    }

    # Function used to select teachers
    # return objects from Teacher Class
    public function select_teachers() {

      $query = 'SELECT * FROM teachers';

      # Query execution
      $result = $this->_db->query($query);

      # Construct  a table of objects Teacher
      $table = array();
      if ($result->rowcount()!=0) {
        while ($row = $result->fetch()) {
          $table[] = new Teacher($row->teacher_mail,$row->name,$row->first_name,$row->responsability);
        }
      }
      return $table;
    }

    # Function used to select weeks
    # return objects from Week Class
    public function select_weeks() {

      $query = 'SELECT * FROM weeks';

      # Query execution
      $result = $this->_db->query($query);

      # Construct  a table of objects Week
      $table = array();
      if ($result->rowcount()!=0) {
        while ($row = $result->fetch()) {
          $table[] = new Week($row->week_id,$row->start_date,$row->term);
        }
      }
      return $table;
    }

	# Function used to select series
    # return objects from serie Class
    public function select_series($block='') {
		if($block === ''){
			$query = 'SELECT * FROM series';
		} else{
			$query = 'SELECT * FROM series WHERE block='. $this->_db->quote($block);
		}

      # Query execution
      $result = $this->_db->query($query);

      # Construct  a table of objects Serie
      $table = array();
      if ($result->rowcount()!=0) {
        while ($row = $result->fetch()) {
          $table[] = new Serie($row->serie_num,$row->block);
        }
      }
      return $table;
    }

	# Function used to select courses
    # return objects from course Class
    public function select_courses($block='') {
		if($block === ''){
			$query = 'SELECT * FROM courses';
		} else{
			$query = 'SELECT * FROM courses WHERE block='. $this->_db->quote($block);
		}

      # Query execution
      $result = $this->_db->query($query);

      # Construct  a table of objects Course
      $table = array();
      if ($result->rowcount()!=0) {
        while ($row = $result->fetch()) {
          $table[] = new Course($row->name,$row->code,$row->term,$row->ue_aa,$row->ects,$row->abbreviation);
        }
      }
      return $table;
    }


    # Function used to select sessions
    # return objects from Session Class
    public function select_sessions() {

      $query = 'SELECT * FROM sessions_type';

      # Query execution
      $result = $this->_db->query($query);

      # Construct  a table of objects Session
      $table = array();
      if ($result->rowcount()!=0) {
        while ($row = $result->fetch()) {
          $table[] = new Session($row->session_id,$row->code,$row->session_name,$row->type);
        }
      }
      return $table;
    }

    # Function used to select presences sheets
    # return objects from PresenceSheet Class
    public function select_presences_sheets() {

      $query = 'SELECT * FROM presences_sheets';

      # Query execution
      $result = $this->_db->query($query);

      # Construct  a table of objects PresenceSheet
      $table = array();
      if ($result->rowcount()!=0) {
        while ($row = $result->fetch()) {
          $table[] = new PresenceSheet($row->presence_sheet_id,$row->session_id,$row->teacher_mail,$row->week_id);
        }
      }
      return $table;
    }

    # Function used to select presences
    # return objects from Presence Class
    public function select_presences($email) {

      $query = 'SELECT c.name,st.session_name,st.type, p.presence, w.start_date
                FROM courses c,sessions_type st, presences p, weeks w, presences_sheets ps
                WHERE st.session_id = ps.session_id
                  AND st.code = c.code
                  AND p.id_sheet = ps.presence_sheet_id
                  AND w.week_id = ps.week_id
                  AND student_mail='. $this->_db->quote($email);

      # Query execution
      $result = $this->_db->query($query);

      # Construct  a table of objects Presence
      $table = array();
      if ($result->rowcount()!=0) {
        while ($row = $result->fetch()) {
          $table[] = new Presence($row->name,$row->session_name,$row->type,$row->presence,$row->start_date);
        }
      }
      return $table;
    }
    # --------------------------------------------------------------------------
    # INSERT scripts -----------------------------------------------------------
	public function insert_teacher($email,$name,$firstName,$responsability) {

		$query = 'INSERT INTO teachers (teacher_mail, name, first_name, responsability)
				  values ('. $this->_db->quote($email) . ',' . $this->_db->quote($name) . ',' . $this->_db->quote($firstName) . ',' . $this->_db->quote($responsability) . ')';
		$this->_db->prepare($query)->execute();
	}

	public function insert_student($email,$name,$firstName,$block) {
    $emailtrimmed = trim($email);
		$query = 'INSERT INTO students (student_mail, name, first_name, block)
				  values ('. $this->_db->quote($emailtrimmed) . ',' . $this->_db->quote($name) . ',' . $this->_db->quote($firstName) . ',' . $this->_db->quote($block) . ')';
		$this->_db->prepare($query)->execute();
	}

	public function insert_serie($num,$block){
		$query = 'INSERT INTO series (serie_num, block)
				  values ('. $this->_db->quote($num) . ',' . $this->_db->quote($block). ')';

		$this->_db->prepare($query)->execute();
	}

  public function insert_weeks($term,$week,$start_date){
		$query = 'INSERT INTO weeks (week_id, start_date, term)
				  values ('. $this->_db->quote($week) . ',' . $this->_db->quote($start_date). ',' . $this->_db->quote($term). ')';

		$this->_db->prepare($query)->execute();
	}

  public function insert_courses($name,$code,$term,$ueAa,$ects,$abbreviation) {
    $block = ' ';
    if(preg_match('/^I1.*$/', $code)){
      $block = 'bloc1';
    }
    elseif(preg_match('/^I2.*$/', $code)){
      $block = 'bloc2';
    }else{
      $block = 'bloc3';
    }
    $query = 'INSERT INTO courses (code, name, term, ue_aa, ects, block, abbreviation)
          values ('. $this->_db->quote($code) . ',' . $this->_db->quote($name) . ',' . $this->_db->quote($term) . ',' . $this->_db->quote($ueAa). ',' . $this->_db->quote($ects) . ',' . $this->_db->quote($block) . ',' . $this->_db->quote($abbreviation) . ')';
    $this->_db->prepare($query)->execute();
  }

  public function insert_sessions($id,$code,$name,$type){
    $query = 'INSERT INTO sessions_type (session_id, code, session_name, type)
          values ('.$id. ',' . $this->_db->quote($code). ',' . $this->_db->quote($name). ',' . $this->_db->quote($type). ')';

    $this->_db->prepare($query)->execute();
  }

  public function insert_programs($serie,$id){
    $query = 'INSERT INTO programs (serie_num, session_id)
          values (' . $this->_db->quote($serie). ',' . $this->_db->quote($id). ')';

    $this->_db->prepare($query)->execute();
  }

  public function insert_presences_sheets($session,$teacher,$week){
    $query = 'INSERT INTO presences_sheets (session_id, teacher_mail, week_id)
          values (' . $this->_db->quote($session). ',' . $this->_db->quote($teacher). ',' . $this->_db->quote($week). ')';

    $this->_db->prepare($query)->execute();
  }

  public function insert_presences($emailStu,$idSheet,$presence=''){
    $query = 'INSERT INTO presences (student_mail, id_sheet, presence)
          values (' . $this->_db->quote($emailStu). ',' . $this->_db->quote($idSheet). ',' . $this->_db->quote($presence). ')';

    $this->_db->prepare($query)->execute();
  }

  # -------------------------------------------------------------------------------
  # UPADATE scripts ---------------------------------------------------------------

  # Function used to put the student in a serie
  public function update_students($email,$serie='') {
      if($serie != ''){
  		$query = 'UPDATE students SET serie_num=' . $this->_db->quote($serie) .
  				 'WHERE student_mail='.$this->_db->quote($email);
      } else {
        $query = 'UPDATE students SET serie_num= NULL WHERE student_mail= '.$this->_db->quote($email);
      }
  		$this->_db->prepare($query)->execute();
  	}
    #--------------------------------------------------------------------------------
    # DELETE scripts  --------------------------------------------------------------
    public function delete_serie($num,$block){
    		$query = 'DELETE FROM series WHERE serie_num='. $this->_db->quote($num) .'AND block='. $this->_db->quote($block);
    		$this->_db->prepare($query)->execute();
    }

    public function delete_precenses(){
      $query = 'DELETE FROM presences';
      $this->_db->prepare($query)->execute();
    }

    public function delete_precenses_sheets(){
      $query = 'DELETE FROM presences_sheets';
      $this->_db->prepare($query)->execute();
    }

    public function delete_students(){
      $query = 'DELETE FROM students';
      $this->_db->prepare($query)->execute();
    }

    public function delete_programs(){
      $query = 'DELETE FROM programs';
      $this->_db->prepare($query)->execute();
    }

    public function delete_weeks(){
      $query = 'DELETE FROM weeks';
      $this->_db->prepare($query)->execute();
    }

    public function delete_teachers(){
      $query = 'DELETE FROM teachers WHERE responsability != "true"';
      $this->_db->prepare($query)->execute();
    }

    public function delete_sessions(){
      $query = 'DELETE FROM sessions_type';
      $this->_db->prepare($query)->execute();
    }

    public function delete_courses(){
      $query = 'DELETE FROM courses';
      $this->_db->prepare($query)->execute();
    }

    public function delete_series(){
      $query = 'DELETE FROM series';
      $this->_db->prepare($query)->execute();
    }
    # --------------------------------------------------------------------------
    # Checking the existance of things

    public function student_exists($student) {
      $emailtrimmed = trim($student);
  		$query = 'SELECT * FROM students WHERE student_mail= '.$this->_db->quote($emailtrimmed);
  		$result = $this->_db->query($query);
  		$exists = false;
  		if ($result->rowcount()!=0) {
  			$exists = true;
  		}
  		return $exists;
    }

    public function teachers_exists($teacher) {
  		$query = 'SELECT * FROM teachers WHERE teacher_mail='.$this->_db->quote($teacher);
  		$result = $this->_db->query($query);
  		$exists = false;
  		if ($result->rowcount()!=0) {
  			$exists = true;
  		}
  		return $exists;
    }

    public function course_exists($course) {
  		$query = 'SELECT * FROM courses WHERE code='.$this->_db->quote($course);
  		$result = $this->_db->query($query);
  		$exists = false;
  		if ($result->rowcount()!=0) {
  			$exists = true;
  		}
   		return $exists;
    }

    public function week_exists($id) {
      $query = 'SELECT * FROM weeks WHERE week_id='.$this->_db->quote($id);
      $result = $this->_db->query($query);
      $exists = false;
      if ($result->rowcount()!=0) {
        $exists = true;
      }
      return $exists;
    }

    public function serie_exists($num,$block) {
    		$query = 'SELECT * FROM series WHERE serie_num='.$this->_db->quote($num).'AND block='.$this->_db->quote($block);
    		$result = $this->_db->query($query);
    		$exists = false;
    		if ($result->rowcount()!=0) {
    			$exists = true;
    		}
     		return $exists;
      }
    # --------------------------------------------------------------------------
    # Allowing scripts
    # Function that returns the mail of the student if he's allowed

    public function allowed_student($email) {
		$query = 'SELECT * FROM students WHERE student_mail= '.$this->_db->quote($email);
		$result = $this->_db->query($query);
		$goodmail = 'NE';
		if ($result->rowcount()!=0) {
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$goodmail = $row['student_mail'];
		}
		return $goodmail;
	}

    # Function that returns the mail of the teacher if he's allowed
    public function allowed_teacher($email) {
		$query = 'SELECT * FROM teachers WHERE teacher_mail='.$this->_db->quote($email);
		$result = $this->_db->query($query);
		$goodmail = 'NE';
		if ($result->rowcount()!=0) {
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$goodmail = $row['teacher_mail'];
		}
		return $goodmail;
	}

  # Function that returns the mail of the admin if he's allowed
	public function allowed_admin($email) {
		$query = 'SELECT * FROM teachers WHERE teacher_mail='.$this->_db->quote($email).'AND responsability LIKE '.$this->_db->quote('%true%');
		$result = $this->_db->query($query);
		$goodmail = 'NE';
		if ($result->rowcount()!=0) {
		  $row = $result->fetch(PDO::FETCH_ASSOC);
		  $goodmail = $row['teacher_mail'];
		}
		return $goodmail;
	}

	# Function that returns the mail of the block responsible if he's allowed
	public function allowed_responsible($email) {
		$query = 'SELECT * FROM teachers WHERE teacher_mail='.$this->_db->quote($email).'AND responsability LIKE '.$this->_db->quote('%bloc%');
		$result = $this->_db->query($query);
		$goodmail = 'NE';
		if ($result->rowcount()!=0) {
		  $row = $result->fetch(PDO::FETCH_ASSOC);
		  $goodmail = $row['teacher_mail'];
		}
    return $goodmail;
    }

}
