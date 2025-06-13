import { Args, Mutation, Query, Resolver } from '@nestjs/graphql';

@Resolver('Student')
export class StudentResolver {
  private students = [
    {
      id: 1,
      name: 'Mark',
      idCard: '123456',
      className: 'A',
    },
    {
      id: 2,
      name: 'John',
      idCard: '654321',
      className: 'B',
    },
    {
      id: 3,
      name: 'Jane',
      idCard: '987654',
      className: 'C',
    },
  ];

  @Query('students')
  getAllStudents() {
    return this.students;
  }

  @Query('student')
  getStudentByClassName(@Args('className') className: string) {
    return this.students.find((student) => student.className === className);
  }

  @Mutation('enrollStudent')
  enrollStudent(
    @Args('name') name: string,
    @Args('idCard') idCard: string,
    @Args('className') className: string,
  ) {
    const sortedStudent = this.students.sort((a, b) => a.id - b.id);
    const lastId =
      sortedStudent.length > 0 ? sortedStudent[sortedStudent.length - 1].id : 0;
    const newStudent = {
      id: lastId + 1,
      name,
      idCard,
      className,
    };
    this.students.push(newStudent);
    return newStudent;
  }

  @Mutation('updateStudent')
  updateStudent(
    @Args('id') id: number,
    @Args('name') name: string,
    @Args('idCard') idCard: string,
    @Args('className') className: string,
  ) {
    const studentIndex = this.students.findIndex((student) => student.id == id);
    if (studentIndex === -1) {
      throw new Error('Student not found');
    }
    const updatedStudent = {
      ...this.students[studentIndex],
      name,
      idCard,
      className,
    };
    this.students[studentIndex] = updatedStudent;
    return updatedStudent;
  }

  @Mutation('removeStudent')
  removeStudent(@Args('id') id: number) {
    try {
      const studentIndex = this.students.findIndex(
        (student) => student.id == id,
      );
      if (studentIndex === -1) {
        return false;
      }
      this.students.splice(studentIndex, 1);
      return true;
    } catch (e) {
      console.error(e);
      return false;
    }
  }
}
